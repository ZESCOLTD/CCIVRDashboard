<div class="app">

    {{-- ================= LEFT SIDEBAR ================= --}}
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="profile">
                <div class="avatar"></div>
                <div>
                    <div>8900</div>
                    <div class="status">Registered</div>
                </div>
            </div>
            <div class="sidebar-icons">
                <span>📞</span>
                <span>👥</span>
                <span>⚙️</span>
            </div>
        </div>

        <div class="search">
            <input type="text" placeholder="Find someone..." />
        </div>

        <div class="contacts">
            @foreach ($contacts as $contact)
                <div class="contact {{ $selectedContact === $contact['id'] ? 'active' : '' }}"
                    wire:click="selectContact('{{ $contact['id'] }}')">
                    <div class="avatar"></div>
                    <div class="contact-info">
                        <div class="contact-name">{{ $contact['id'] }}</div>
                        <div class="contact-date">{{ $contact['date'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ================= CHAT PANEL ================= --}}
    <div class="chat">
        <div class="chat-header">
            <div class="chat-user">
                <div class="avatar"></div>
                <div>{{ $selectedContact }}</div>
            </div>
            <div class="chat-icons">
                <span>📞</span>
                <span>🎥</span>
                <span>⋮</span>
            </div>
        </div>

        <div class="chat-body">
            @foreach ($calls as $call)
                <div class="call-log {{ $call['type'] === 'missed' ? 'missed' : '' }}">
                    {{ $call['type'] === 'missed' ? '❌' : '📞' }}
                    {{ $call['message'] }}
                    <div class="call-date">{{ $call['date'] }}</div>
                </div>
            @endforeach
        </div>

        <div class="chat-footer">
            <span class="ellipsis">⋯</span>
            <input type="text" placeholder="Type your message here..." />
        </div>
    </div>

    {{-- ================= STYLES ================= --}}
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        .app {
            display: flex;
            height: 100vh;
            background: #fff;
        }

        /* SIDEBAR */
        .sidebar {
            width: 360px;
            border-right: 1px solid #ddd;
            display: flex;
            flex-direction: column;
            background: #fff;
        }

        .sidebar-header {
            padding: 10px;
            background: #f0f2f5;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .profile {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ccc;
        }

        .status {
            font-size: 12px;
            color: #4caf50;
        }

        .search {
            padding: 8px;
            background: #f0f2f5;
        }

        .search input {
            width: 100%;
            padding: 8px 12px;
            border-radius: 8px;
            border: none;
            outline: none;
        }

        .contacts {
            overflow-y: auto;
            flex: 1;
        }

        .contact {
            display: flex;
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #f1f1f1;
        }

        .contact:hover {
            background: #f5f6f6;
        }

        .contact.active {
            background: #e9edef;
        }

        .contact-info {
            margin-left: 10px;
        }

        .contact-name {
            font-weight: bold;
            font-size: 14px;
        }

        .contact-date {
            font-size: 11px;
            color: #777;
        }

        /* CHAT */
        .chat {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #efeae2;
        }

        .chat-header {
            padding: 10px;
            background: #f0f2f5;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
        }

        .chat-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chat-body {
            padding: 20px;
            flex: 1;
            overflow-y: auto;
        }

        .call-log {
            background: #e7fce3;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 10px;
            max-width: 75%;
            font-size: 14px;
        }

        .call-log.missed {
            background: #fdeaea;
            color: #b00020;
        }

        .call-date {
            font-size: 11px;
            color: #666;
            margin-top: 4px;
        }

        .chat-footer {
            padding: 10px;
            background: #f0f2f5;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .chat-footer input {
            flex: 1;
            padding: 10px 14px;
            border-radius: 20px;
            border: none;
            outline: none;
        }
    </style>

</div>
