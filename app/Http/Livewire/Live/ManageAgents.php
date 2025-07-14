<?php

namespace App\Http\Livewire\Live;

use App\Models\Live\CCAgent;
use App\Models\User;
use App\Services\PBX\GetSetNumbersService;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class ManageAgents extends Component
{

    public $agent_name;
    public $agent_endpoint;
    public $agent_man_no;
    public $agent_user_id;
    public $agent_status;
    public $agent_state;
    public  $agent_set_number;

    public $selected;
    public $search;

    // Validation Rules
    protected $rules = [

        'agent_man_no' => 'required',
        'agent_name' => 'required',
        'agent_endpoint' => 'required',
        'agent_user_id' => 'required'
    ];

    private $ari_username = 'asterisk'; // Your ARI username
    private $ari_password = 'asterisk';   // Your ARI password

    // public function mount($id)
    // {
    //     $this->selected = $id;
    // }

    public function render()
    {


        $query = CCAgent::query()->orderBy('endpoint', 'DESC');
        // ::with('agent')->orderBy('created_at', 'DESC');

        if ($this->search) {
            $search = strtolower($this->search);
            $query->where(function ($query) use ($search) {
                $query->whereRaw('LOWER(man_no) like ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(name) like ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(endpoint) like ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(state) like ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(status) like ?', ['%' . $search . '%'])
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->whereRaw('LOWER(name) like ?', ['%' . $search . '%'])
                        ->orderBy('endpoint', 'DESC');

                    });
            });
        }

        $agents =  $query->paginate(10);

        return view('livewire.live.manage.manage-agents', ['agents' => $agents]);
    }

    public function create()
    {
        // dd([$this->agent_name, $this->agent_endpoint]);

        $response = Http::withBasicAuth($this->ari_username, $this->ari_password) // THIS IS WHERE BASIC AUTH IS ADDED
        ->put("http://10.44.0.70:8088/ari/asterisk/config/dynamic/res_pjsip/endpoint/" . $this->agent_endpoint,

        [
            "fields"=> [
                [
                    "attribute"=> "100rel",
                    "value"=> "yes"
                ],
                [
                    "attribute"=> "accept_multiple_sdp_answers",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "accountcode",
                    "value"=> ""
                ],
                [
                    "attribute"=> "acl",
                    "value"=> ""
                ],
                [
                    "attribute"=> "aggregate_mwi",
                    "value"=> "true"
                ],
                [
                    "attribute"=> "allow",
                    "value"=> "(opus|alaw|vp9|vp8|g729)"
                ],
                [
                    "attribute"=> "allow_overlap",
                    "value"=> "true"
                ],
                [
                    "attribute"=> "allow_subscribe",
                    "value"=> "true"
                ],
                [
                    "attribute"=> "allow_transfer",
                    "value"=> "true"
                ],
                [
                    "attribute"=> "allow_unauthenticated_options",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "aors",
                    "value"=> $this->agent_endpoint
                ],
                [
                    "attribute"=> "asymmetric_rtp_codec",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "auth",
                    "value"=> $this->agent_endpoint
                ],
                [
                    "attribute"=> "bind_rtp_to_media_address",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "bundle",
                    "value"=> "true"
                ],
                [
                    "attribute"=> "call_group",
                    "value"=> ""
                ],
                [
                    "attribute"=> "callerid",
                    "value"=> $this->agent_name." <" . $this->agent_endpoint . ">"
                ],
                [
                    "attribute"=> "callerid_privacy",
                    "value"=> "allowed_not_screened"
                ],
                [
                    "attribute"=> "callerid_tag",
                    "value"=> ""
                ],
                [
                    "attribute"=> "codec_prefs_incoming_answer",
                    "value"=> "prefer:pending, operation:intersect, keep:all, transcode:allow"
                ],
                [
                    "attribute"=> "codec_prefs_incoming_offer",
                    "value"=> "prefer:pending, operation:intersect, keep:all, transcode:allow"
                ],
                [
                    "attribute"=> "codec_prefs_outgoing_answer",
                    "value"=> "prefer:pending, operation:intersect, keep:all, transcode:allow"
                ],
                [
                    "attribute"=> "codec_prefs_outgoing_offer",
                    "value"=> "prefer:pending, operation:union, keep:all, transcode:allow"
                ],
                [
                    "attribute"=> "connected_line_method",
                    "value"=> "invite"
                ],
                [
                    "attribute"=> "contact_acl",
                    "value"=> ""
                ],
                [
                    "attribute"=> "context",
                    "value"=> "from-zesco"
                ],
                [
                    "attribute"=> "cos_audio",
                    "value"=> "0"
                ],
                [
                    "attribute"=> "cos_video",
                    "value"=> "0"
                ],
                [
                    "attribute"=> "device_state_busy_at",
                    "value"=> "1"
                ],
                [
                    "attribute"=> "direct_media",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "direct_media_glare_mitigation",
                    "value"=> "none"
                ],
                [
                    "attribute"=> "direct_media_method",
                    "value"=> "invite"
                ],
                [
                    "attribute"=> "disable_direct_media_on_nat",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "dtls_auto_generate_cert",
                    "value"=> "Yes"
                ],
                [
                    "attribute"=> "dtls_ca_file",
                    "value"=> ""
                ],
                [
                    "attribute"=> "dtls_ca_path",
                    "value"=> ""
                ],
                [
                    "attribute"=> "dtls_cert_file",
                    "value"=> ""
                ],
                [
                    "attribute"=> "dtls_cipher",
                    "value"=> ""
                ],
                [
                    "attribute"=> "dtls_fingerprint",
                    "value"=> "SHA-256"
                ],
                [
                    "attribute"=> "dtls_private_key",
                    "value"=> ""
                ],
                [
                    "attribute"=> "dtls_rekey",
                    "value"=> "0"
                ],
                [
                    "attribute"=> "dtls_setup",
                    "value"=> "actpass"
                ],
                [
                    "attribute"=> "dtls_verify",
                    "value"=> "Yes"
                ],
                [
                    "attribute"=> "dtmf_mode",
                    "value"=> "rfc4733"
                ],
                [
                    "attribute"=> "fax_detect",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "fax_detect_timeout",
                    "value"=> "0"
                ],
                [
                    "attribute"=> "follow_early_media_fork",
                    "value"=> "true"
                ],
                [
                    "attribute"=> "force_avp",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "force_rport",
                    "value"=> "true"
                ],
                [
                    "attribute"=> "from_domain",
                    "value"=> ""
                ],
                [
                    "attribute"=> "from_user",
                    "value"=> ""
                ],
                [
                    "attribute"=> "g726_non_standard",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "geoloc_incoming_call_profile",
                    "value"=> ""
                ],
                [
                    "attribute"=> "geoloc_outgoing_call_profile",
                    "value"=> ""
                ],
                [
                    "attribute"=> "ice_support",
                    "value"=> "true"
                ],
                [
                    "attribute"=> "identify_by",
                    "value"=> "username,ip"
                ],
                [
                    "attribute"=> "ignore_183_without_sdp",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "inband_progress",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "incoming_call_offer_pref",
                    "value"=> "local"
                ],
                [
                    "attribute"=> "incoming_mwi_mailbox",
                    "value"=> ""
                ],
                [
                    "attribute"=> "language",
                    "value"=> ""
                ],
                [
                    "attribute"=> "mailboxes",
                    "value"=> ""
                ],
                [
                    "attribute"=> "max_audio_streams",
                    "value"=> "1"
                ],
                [
                    "attribute"=> "max_video_streams",
                    "value"=> "1"
                ],
                [
                    "attribute"=> "media_address",
                    "value"=> ""
                ],
                [
                    "attribute"=> "media_encryption",
                    "value"=> "dtls"
                ],
                [
                    "attribute"=> "media_encryption_optimistic",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "media_use_received_transport",
                    "value"=> "true"
                ],
                [
                    "attribute"=> "message_context",
                    "value"=> "textmessages"
                ],
                [
                    "attribute"=> "moh_passthrough",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "moh_suggest",
                    "value"=> "default"
                ],
                [
                    "attribute"=> "mwi_from_user",
                    "value"=> ""
                ],
                [
                    "attribute"=> "mwi_subscribe_replaces_unsolicited",
                    "value"=> "no"
                ],
                [
                    "attribute"=> "named_call_group",
                    "value"=> ""
                ],
                [
                    "attribute"=> "named_pickup_group",
                    "value"=> ""
                ],
                [
                    "attribute"=> "notify_early_inuse_ringing",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "one_touch_recording",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "outbound_auth",
                    "value"=> ""
                ],
                [
                    "attribute"=> "outbound_proxy",
                    "value"=> ""
                ],
                [
                    "attribute"=> "outgoing_call_offer_pref",
                    "value"=> "remote_merge"
                ],
                [
                    "attribute"=> "overlap_context",
                    "value"=> ""
                ],
                [
                    "attribute"=> "pickup_group",
                    "value"=> ""
                ],
                [
                    "attribute"=> "preferred_codec_only",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "record_off_feature",
                    "value"=> "automixmon"
                ],
                [
                    "attribute"=> "record_on_feature",
                    "value"=> "automixmon"
                ],
                [
                    "attribute"=> "refer_blind_progress",
                    "value"=> "true"
                ],
                [
                    "attribute"=> "rewrite_contact",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "rpid_immediate",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "rtcp_mux",
                    "value"=> "true"
                ],
                [
                    "attribute"=> "rtp_engine",
                    "value"=> "asterisk"
                ],
                [
                    "attribute"=> "rtp_ipv6",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "rtp_keepalive",
                    "value"=> "0"
                ],
                [
                    "attribute"=> "rtp_symmetric",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "rtp_timeout",
                    "value"=> "120"
                ],
                [
                    "attribute"=> "rtp_timeout_hold",
                    "value"=> "0"
                ],
                [
                    "attribute"=> "sdp_owner",
                    "value"=> "-"
                ],
                [
                    "attribute"=> "sdp_session",
                    "value"=> "Asterisk"
                ],
                [
                    "attribute"=> "security_negotiation",
                    "value"=> "no"
                ],
                [
                    "attribute"=> "send_aoc",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "send_connected_line",
                    "value"=> "yes"
                ],
                [
                    "attribute"=> "send_diversion",
                    "value"=> "true"
                ],
                [
                    "attribute"=> "send_history_info",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "send_pai",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "send_rpid",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "set_var",
                    "value"=> ""
                ],
                [
                    "attribute"=> "srtp_tag_32",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "stir_shaken",
                    "value"=> "no"
                ],
                [
                    "attribute"=> "stir_shaken_profile",
                    "value"=> ""
                ],
                [
                    "attribute"=> "sub_min_expiry",
                    "value"=> "0"
                ],
                [
                    "attribute"=> "subscribe_context",
                    "value"=> "subscriptions"
                ],
                [
                    "attribute"=> "suppress_q850_reason_headers",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "t38_bind_udptl_to_media_address",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "t38_udptl",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "t38_udptl_ec",
                    "value"=> "none"
                ],
                [
                    "attribute"=> "t38_udptl_ipv6",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "t38_udptl_maxdatagram",
                    "value"=> "0"
                ],
                [
                    "attribute"=> "t38_udptl_nat",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "tenantid",
                    "value"=> ""
                ],
                [
                    "attribute"=> "timers",
                    "value"=> "yes"
                ],
                [
                    "attribute"=> "timers_min_se",
                    "value"=> "90"
                ],
                [
                    "attribute"=> "timers_sess_expires",
                    "value"=> "1800"
                ],
                [
                    "attribute"=> "tone_zone",
                    "value"=> ""
                ],
                [
                    "attribute"=> "tos_audio",
                    "value"=> "0"
                ],
                [
                    "attribute"=> "tos_video",
                    "value"=> "0"
                ],
                [
                    "attribute"=> "transport",
                    "value"=> "transport-wss"
                ],
                [
                    "attribute"=> "trust_connected_line",
                    "value"=> "yes"
                ],
                [
                    "attribute"=> "trust_id_inbound",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "trust_id_outbound",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "use_avpf",
                    "value"=> "true"
                ],
                [
                    "attribute"=> "use_ptime",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "user_eq_phone",
                    "value"=> "false"
                ],
                [
                    "attribute"=> "voicemail_extension",
                    "value"=> ""
                ],
                [
                    "attribute"=> "webrtc",
                    "value"=> "yes"
                ],
            ]
        ]);

        $response = Http::withBasicAuth($this->ari_username, $this->ari_password) // THIS IS WHERE BASIC AUTH IS ADDED
        ->put("http://10.44.0.70:8088/ari/asterisk/config/dynamic/res_pjsip/aor/" . $this->agent_endpoint,
        [
            "fields"=> [
                 [
                      "attribute"=> "support_path",
                      "value"=> "yes"
                 ],
                [
                    "attribute"=> "remove_existing",
                     "value"=> "yes"
            ],
                [
                    "attribute"=> "max_contacts",
                     "value"=> "1"]
             ]

        ]);

        $response = Http::withBasicAuth($this->ari_username, $this->ari_password) // THIS IS WHERE BASIC AUTH IS ADDED
        ->put("http://10.44.0.70:8088/ari/asterisk/config/dynamic/res_pjsip/auth/" . $this->agent_endpoint,
        [
            "fields"=> [
                [
                    "attribute"=> "auth_type",
                    "value"=> "userpass"
                ],
                [
                    "attribute"=> "username",
                    "value"=> $this->agent_endpoint
                ],
                [
                    "attribute"=> "password",
                    "value"=> $this->agent_endpoint
                ]
            ]
        ]);

        CCAgent::updateOrCreate(
            [
                'man_no' => $this->agent_man_no
            ],
            [
                'man_no' => $this->agent_man_no,
                'name' => $this->agent_name,
                'endpoint' => $this->agent_endpoint,
                'user_id' => $this->agent_user_id,
                'set_number' => $this->agent_set_number,
                'state' => 'LOGGED_OUT',
                'status' => 'LOGGED_OUT'
            ]
        );
        $this->resetFields();
        session()->flash('success', 'Agent created successfully.');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function resetFields(){
        $this->agent_man_no= '';
        $this->agent_name = '';
        $this->agent_endpoint = '';
        $this->agent_user_id = '';
        $this->agent_set_number = '';
        $this->agent_status = '';
        $this->agent_state = '';
    }

    public function updatedAgentManNo()
    {
        $user = User::where('man_no', $this->agent_man_no)->first();
        if ($user != null) {
            $this->agent_name = $user->name;
            $this->agent_user_id = $user->id;
        }
    }


    public function getSetNumbers()
    {
        $setNumbers = new GetSetNumbersService();
        $setNumbers->getSetNumbers();
        session()->flash('success', 'Agent Set Numbers Synced successfully.');
    }
}
