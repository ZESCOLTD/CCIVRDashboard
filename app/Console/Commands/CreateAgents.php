<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CCAgent; // Your Call Center Agent Model
use App\Models\Live\CCAgent as LiveCCAgent;
use Illuminate\Support\Facades\Http;

class CreateAgents extends Command
{
    protected $signature = 'agents:provision {--force : Provision all agents, even if already configured}';
    protected $description = 'Retrieves agents from DB and creates/updates their PJSIP configurations via Asterisk ARI.';

    // Define ARI credentials. Best practice is to load these from .env/config.
    protected $ari_username;
    protected $ari_password;
    protected $ari_base_url;

    public function __construct()
    {
        parent::__construct();
        // Load ARI credentials securely from environment variables
        $this->ari_username = env('ARI_USERNAME', 'asterisk');
        $this->ari_password = env('ARI_PASSWORD', 'asterisk');
        $this->ari_base_url = env('ARI_BASE_URL', 'http://10.44.0.70:8088/ari');
    }

    public function handle()
    {
        $this->info('Starting Asterisk PJSIP Agent Provisioning...');

        // 1. Get Agents from Database
        $agents = LiveCCAgent::all();
        $count = $agents->count();
        $this->info("Found {$count} agents to process.");

        if ($count === 0) {
            $this->comment('No agents found in the database.');
            return 0;
        }

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        // 2. Loop Through Agents and Call ARI for Configuration
        foreach ($agents as $agent) {
            // Replace internal properties ($this->...) with agent object properties ($agent->...)
            $agent_endpoint = $agent->endpoint;
            $agent_name = $agent->name;

            $this->line("\nProcessing Agent: {$agent_name} (Endpoint: {$agent_endpoint})...");

            // --- 2a. CREATE ENDPOINT CONFIGURATION (res_pjsip/endpoint) ---
            $endpoint_uri = "{$this->ari_base_url}/asterisk/config/dynamic/res_pjsip/endpoint/" . $agent_endpoint;

            $endpoint_response = Http::withBasicAuth($this->ari_username, $this->ari_password)
                ->put($endpoint_uri, [
                    "fields" => $this->getEndpointFields($agent_name, $agent_endpoint),
                ])
                ->close(); // <--- ADDED: Explicitly close the connection;
            usleep(250000); // Wait 250 milliseconds
            $this->logResponse('ENDPOINT', $endpoint_response, $agent_endpoint);

            // --- 2b. CREATE AOR CONFIGURATION (res_pjsip/aor) ---
            $aor_uri = "{$this->ari_base_url}/asterisk/config/dynamic/res_pjsip/aor/" . $agent_endpoint;
            // http://10.44.0.70:8088/ari/asterisk/config/dynamic/res_pjsip/auth/"

            $aor_response = Http::withBasicAuth($this->ari_username, $this->ari_password)
                ->put($aor_uri, [
                    "fields" => $this->getAorFields(),
                ])
                ->close(); // <--- ADDED: Explicitly close the connection
            usleep(250000); // Wait 250 milliseconds
            $this->logResponse('AOR', $aor_response, $agent_endpoint);

            // --- 2c. CREATE AUTH CONFIGURATION (res_pjsip/auth) ---
            $auth_uri = "{$this->ari_base_url}/asterisk/config/dynamic/res_pjsip/auth/" . $agent_endpoint;

            // $auth_response = Http::withBasicAuth($this->ari_username, $this->ari_password)
            //     ->put($auth_uri, [
            //         "fields" => $this->getAuthFields($agent_endpoint),
            //     ])
            //     ->close(); // <--- ADDED: Explicitly close the connection

            // --- 2c. CREATE AUTH CONFIGURATION (res_pjsip/auth) ---
            $auth_response = Http::withBasicAuth($this->ari_username, $this->ari_password)
                ->put($auth_uri, ["fields" => $this->getAuthFields($agent_endpoint)])
                ->close(); // <--- MUST BE HERE

            usleep(250000); // Wait 250 milliseconds
            $this->logResponse('AUTH', $auth_response, $agent_endpoint);

            // --- 2d. Update Local Database Record ---
            // This logic simply updates the local record, which is redundant
            // if the agent already exists, but useful for initial provisioning.
            // $agent->update([
            //     'name' => $agent->name,
            //     'endpoint' => $agent->endpoint,
            //     'user_id' => $agent->user_id, // assuming these are pre-set on the Eloquent model
            //     'set_number' => $agent->set_number,
            //     // You may want to set a 'provisioned' status here
            // ]);

            $bar->advance();
        }

        $bar->finish();
        $this->info("\n\nAgent provisioning process complete!");

        return 0;
    }

    // --- HELPER FUNCTIONS ---

    protected function logResponse($type, $response, $endpoint)
    {
        if ($response->successful()) {
            $this->comment("   [SUCCESS] {$type} config for {$endpoint} created/updated.");
        } else {
            $this->error("   [FAILED] {$type} config for {$endpoint}. Status: " . $response->status());
            // Optionally log the full body for debugging
            // $this->error("   Response Body: " . $response->body());
        }
    }

    protected function getEndpointFields($agent_name, $agent_endpoint)
    {
        // This is the huge array from your original create() function.
        // I have isolated it into a dedicated method for readability.
        // NOTE: The CallerID line uses the agent-specific variables.
        return [
            [
                "attribute" => "100rel",
                "value" => "yes"
            ],
            [
                "attribute" => "accept_multiple_sdp_answers",
                "value" => "false"
            ],
            [
                "attribute" => "accountcode",
                "value" => ""
            ],
            [
                "attribute" => "acl",
                "value" => ""
            ],
            [
                "attribute" => "aggregate_mwi",
                "value" => "true"
            ],
            [
                "attribute" => "allow",
                "value" => "(opus|alaw|vp9|vp8|g729)"
            ],
            [
                "attribute" => "allow_overlap",
                "value" => "true"
            ],
            [
                "attribute" => "allow_subscribe",
                "value" => "true"
            ],
            [
                "attribute" => "allow_transfer",
                "value" => "true"
            ],
            [
                "attribute" => "allow_unauthenticated_options",
                "value" => "false"
            ],
            [
                "attribute" => "aors",
                "value" => $agent_endpoint
            ],
            [
                "attribute" => "asymmetric_rtp_codec",
                "value" => "false"
            ],
            [
                "attribute" => "auth",
                "value" => $agent_endpoint
            ],
            [
                "attribute" => "bind_rtp_to_media_address",
                "value" => "false"
            ],
            [
                "attribute" => "bundle",
                "value" => "true"
            ],
            [
                "attribute" => "call_group",
                "value" => ""
            ],
            [
                "attribute" => "callerid",
                "value" => $agent_name . " <" . $agent_endpoint . ">"
            ],
            [
                "attribute" => "callerid_privacy",
                "value" => "allowed_not_screened"
            ],
            [
                "attribute" => "callerid_tag",
                "value" => ""
            ],
            [
                "attribute" => "codec_prefs_incoming_answer",
                "value" => "prefer:pending, operation:intersect, keep:all, transcode:allow"
            ],
            [
                "attribute" => "codec_prefs_incoming_offer",
                "value" => "prefer:pending, operation:intersect, keep:all, transcode:allow"
            ],
            [
                "attribute" => "codec_prefs_outgoing_answer",
                "value" => "prefer:pending, operation:intersect, keep:all, transcode:allow"
            ],
            [
                "attribute" => "codec_prefs_outgoing_offer",
                "value" => "prefer:pending, operation:union, keep:all, transcode:allow"
            ],
            [
                "attribute" => "connected_line_method",
                "value" => "invite"
            ],
            [
                "attribute" => "contact_acl",
                "value" => ""
            ],
            [
                "attribute" => "context",
                "value" => "from-zesco"
            ],
            [
                "attribute" => "cos_audio",
                "value" => "0"
            ],
            [
                "attribute" => "cos_video",
                "value" => "0"
            ],
            [
                "attribute" => "device_state_busy_at",
                "value" => "1"
            ],
            [
                "attribute" => "direct_media",
                "value" => "false"
            ],
            [
                "attribute" => "direct_media_glare_mitigation",
                "value" => "none"
            ],
            [
                "attribute" => "direct_media_method",
                "value" => "invite"
            ],
            [
                "attribute" => "disable_direct_media_on_nat",
                "value" => "false"
            ],
            [
                "attribute" => "dtls_auto_generate_cert",
                "value" => "Yes"
            ],
            [
                "attribute" => "dtls_ca_file",
                "value" => ""
            ],
            [
                "attribute" => "dtls_ca_path",
                "value" => ""
            ],
            [
                "attribute" => "dtls_cert_file",
                "value" => ""
            ],
            [
                "attribute" => "dtls_cipher",
                "value" => ""
            ],
            [
                "attribute" => "dtls_fingerprint",
                "value" => "SHA-256"
            ],
            [
                "attribute" => "dtls_private_key",
                "value" => ""
            ],
            [
                "attribute" => "dtls_rekey",
                "value" => "0"
            ],
            [
                "attribute" => "dtls_setup",
                "value" => "actpass"
            ],
            [
                "attribute" => "dtls_verify",
                "value" => "Yes"
            ],
            [
                "attribute" => "dtmf_mode",
                "value" => "rfc4733"
            ],
            [
                "attribute" => "fax_detect",
                "value" => "false"
            ],
            [
                "attribute" => "fax_detect_timeout",
                "value" => "0"
            ],
            [
                "attribute" => "follow_early_media_fork",
                "value" => "true"
            ],
            [
                "attribute" => "force_avp",
                "value" => "false"
            ],
            [
                "attribute" => "force_rport",
                "value" => "true"
            ],
            [
                "attribute" => "from_domain",
                "value" => ""
            ],
            [
                "attribute" => "from_user",
                "value" => ""
            ],
            [
                "attribute" => "g726_non_standard",
                "value" => "false"
            ],
            [
                "attribute" => "geoloc_incoming_call_profile",
                "value" => ""
            ],
            [
                "attribute" => "geoloc_outgoing_call_profile",
                "value" => ""
            ],
            [
                "attribute" => "ice_support",
                "value" => "true"
            ],
            [
                "attribute" => "identify_by",
                "value" => "username,ip"
            ],
            [
                "attribute" => "ignore_183_without_sdp",
                "value" => "false"
            ],
            [
                "attribute" => "inband_progress",
                "value" => "false"
            ],
            [
                "attribute" => "incoming_call_offer_pref",
                "value" => "local"
            ],
            [
                "attribute" => "incoming_mwi_mailbox",
                "value" => ""
            ],
            [
                "attribute" => "language",
                "value" => ""
            ],
            [
                "attribute" => "mailboxes",
                "value" => ""
            ],
            [
                "attribute" => "max_audio_streams",
                "value" => "1"
            ],
            [
                "attribute" => "max_video_streams",
                "value" => "1"
            ],
            [
                "attribute" => "media_address",
                "value" => ""
            ],
            [
                "attribute" => "media_encryption",
                "value" => "dtls"
            ],
            [
                "attribute" => "media_encryption_optimistic",
                "value" => "false"
            ],
            [
                "attribute" => "media_use_received_transport",
                "value" => "true"
            ],
            [
                "attribute" => "message_context",
                "value" => "textmessages"
            ],
            [
                "attribute" => "moh_passthrough",
                "value" => "false"
            ],
            [
                "attribute" => "moh_suggest",
                "value" => "default"
            ],
            [
                "attribute" => "mwi_from_user",
                "value" => ""
            ],
            [
                "attribute" => "mwi_subscribe_replaces_unsolicited",
                "value" => "no"
            ],
            [
                "attribute" => "named_call_group",
                "value" => ""
            ],
            [
                "attribute" => "named_pickup_group",
                "value" => ""
            ],
            [
                "attribute" => "notify_early_inuse_ringing",
                "value" => "false"
            ],
            [
                "attribute" => "one_touch_recording",
                "value" => "false"
            ],
            [
                "attribute" => "outbound_auth",
                "value" => ""
            ],
            [
                "attribute" => "outbound_proxy",
                "value" => ""
            ],
            [
                "attribute" => "outgoing_call_offer_pref",
                "value" => "remote_merge"
            ],
            [
                "attribute" => "overlap_context",
                "value" => ""
            ],
            [
                "attribute" => "pickup_group",
                "value" => ""
            ],
            [
                "attribute" => "preferred_codec_only",
                "value" => "false"
            ],
            [
                "attribute" => "record_off_feature",
                "value" => "automixmon"
            ],
            [
                "attribute" => "record_on_feature",
                "value" => "automixmon"
            ],
            [
                "attribute" => "refer_blind_progress",
                "value" => "true"
            ],
            [
                "attribute" => "rewrite_contact",
                "value" => "false"
            ],
            [
                "attribute" => "rpid_immediate",
                "value" => "false"
            ],
            [
                "attribute" => "rtcp_mux",
                "value" => "true"
            ],
            [
                "attribute" => "rtp_engine",
                "value" => "asterisk"
            ],
            [
                "attribute" => "rtp_ipv6",
                "value" => "false"
            ],
            [
                "attribute" => "rtp_keepalive",
                "value" => "0"
            ],
            [
                "attribute" => "rtp_symmetric",
                "value" => "false"
            ],
            [
                "attribute" => "rtp_timeout",
                "value" => "120"
            ],
            [
                "attribute" => "rtp_timeout_hold",
                "value" => "0"
            ],
            [
                "attribute" => "sdp_owner",
                "value" => "-"
            ],
            [
                "attribute" => "sdp_session",
                "value" => "Asterisk"
            ],
            [
                "attribute" => "security_negotiation",
                "value" => "no"
            ],
            [
                "attribute" => "send_aoc",
                "value" => "false"
            ],
            [
                "attribute" => "send_connected_line",
                "value" => "yes"
            ],
            [
                "attribute" => "send_diversion",
                "value" => "true"
            ],
            [
                "attribute" => "send_history_info",
                "value" => "false"
            ],
            [
                "attribute" => "send_pai",
                "value" => "false"
            ],
            [
                "attribute" => "send_rpid",
                "value" => "false"
            ],
            [
                "attribute" => "set_var",
                "value" => ""
            ],
            [
                "attribute" => "srtp_tag_32",
                "value" => "false"
            ],
            [
                "attribute" => "stir_shaken",
                "value" => "no"
            ],
            [
                "attribute" => "stir_shaken_profile",
                "value" => ""
            ],
            [
                "attribute" => "sub_min_expiry",
                "value" => "0"
            ],
            [
                "attribute" => "subscribe_context",
                "value" => "subscriptions"
            ],
            [
                "attribute" => "suppress_q850_reason_headers",
                "value" => "false"
            ],
            [
                "attribute" => "t38_bind_udptl_to_media_address",
                "value" => "false"
            ],
            [
                "attribute" => "t38_udptl",
                "value" => "false"
            ],
            [
                "attribute" => "t38_udptl_ec",
                "value" => "none"
            ],
            [
                "attribute" => "t38_udptl_ipv6",
                "value" => "false"
            ],
            [
                "attribute" => "t38_udptl_maxdatagram",
                "value" => "0"
            ],
            [
                "attribute" => "t38_udptl_nat",
                "value" => "false"
            ],
            [
                "attribute" => "tenantid",
                "value" => ""
            ],
            [
                "attribute" => "timers",
                "value" => "yes"
            ],
            [
                "attribute" => "timers_min_se",
                "value" => "90"
            ],
            [
                "attribute" => "timers_sess_expires",
                "value" => "1800"
            ],
            [
                "attribute" => "tone_zone",
                "value" => ""
            ],
            [
                "attribute" => "tos_audio",
                "value" => "0"
            ],
            [
                "attribute" => "tos_video",
                "value" => "0"
            ],
            [
                "attribute" => "transport",
                "value" => "transport-wss"
            ],
            [
                "attribute" => "trust_connected_line",
                "value" => "yes"
            ],
            [
                "attribute" => "trust_id_inbound",
                "value" => "false"
            ],
            [
                "attribute" => "trust_id_outbound",
                "value" => "false"
            ],
            [
                "attribute" => "use_avpf",
                "value" => "true"
            ],
            [
                "attribute" => "use_ptime",
                "value" => "false"
            ],
            [
                "attribute" => "user_eq_phone",
                "value" => "false"
            ],
            [
                "attribute" => "voicemail_extension",
                "value" => ""
            ],
            [
                "attribute" => "webrtc",
                "value" => "yes"
            ],

        ];
    }

    protected function getAorFields()
    {
        return [
            [
                "attribute" => "support_path",
                "value" => "yes"
            ],
            [
                "attribute" => "remove_existing",
                "value" => "yes"
            ],
            [
                "attribute" => "max_contacts",
                "value" => "1"
            ]
        ];
    }

    protected function getAuthFields($agent_endpoint)
    {
        return [

            [
                "attribute" => "auth_type",
                "value" => "userpass"
            ],
            [
                "attribute" => "username",
                "value" => $agent_endpoint
            ],
            [
                "attribute" => "password",
                "value" => $agent_endpoint
            ]

        ];
    }
}
