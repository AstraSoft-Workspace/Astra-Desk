<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$username = htmlspecialchars($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Astra Chat</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/daisyui@3.6.4/dist/full.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@3.6.4/dist/full.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />



  <style>


      html, body {
    height: 100%;
    margin: 0;
  }

/* Smooth scroll for message area */
#chatBox {
  scroll-behavior: smooth;
}

/* Hide scrollbar in sidebar & message area (only show on hover) */
#chatBox::-webkit-scrollbar,
#userList::-webkit-scrollbar,
#chatList::-webkit-scrollbar {
  width: 0;
  background: transparent;
}

#chatBox:hover::-webkit-scrollbar,
#userList:hover::-webkit-scrollbar,
#chatList:hover::-webkit-scrollbar {
  width: 6px;
}

#chatBox::-webkit-scrollbar-thumb,
#userList::-webkit-scrollbar-thumb,
#chatList::-webkit-scrollbar-thumb {
  background: #555;
  border-radius: 10px;
}

/* Chat message bubbles */
.chat-bubble {
  border-radius: 1rem;
  padding: 0.6rem 1rem;
  font-size: 0.95rem;
  line-height: 1.4;
  max-width: 80%;
  word-wrap: break-word;
  box-shadow: 0 2px 4px rgba(0,0,0,0.15);
}

/* Group & User list hover effect */
#chatList li, #userList li {
  transition: background-color 0.2s ease;
}

/* Selected chat highlight (optional class) */
.active-chat {
  background-color: #3a3b3c;
}

/* Tabs styling for better clarity */
.tabs-boxed .tab {
  border-radius: 8px;
  transition: all 0.2s;
}
.tabs-boxed .tab:hover {
  background-color: #4b5563;
  color: white;
}

/* Placeholder for empty chat */
#chatBox:empty::before {
  content: 'Start chatting by selecting a conversation...';
  display: block;
  text-align: center;
  margin-top: 2rem;
  color: #999;
  font-size: 0.95rem;
  font-style: italic;
}

/* Input glow on focus */
input:focus, .input:focus {
  outline: none;
  box-shadow: 0 0 0 2px #3b82f6;
  border-color: #3b82f6;
}

/* Modal scroll improvements */
.modal-box {
  max-height: 90vh;
  overflow-y: auto;
}

/* Make chat bubbles responsive */
@media (max-width: 768px) {
  .chat-bubble {
    max-width: 100%;
  }

  .tabs {
    font-size: 0.8rem;
  }

  .navbar {
    flex-direction: column;
    align-items: flex-start;
  }

  #messageInput {
    font-size: 0.95rem;
  }
}
</style>


<script>
function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  sidebar.classList.toggle('hidden');
}

</script>


</head>
<body class="bg-base-200 text-white h-full">

<div class="flex flex-col h-screen">
    <!-- Mobile Navbar -->
    <div class="lg:hidden flex justify-between items-center p-4 bg-base-300 border-b border-base-content">
        <div class="flex-1 min-w-0">
            <div class="text-left">
                <div class="text-lg font-semibold truncate">Astra Desk</div>
                <div id="chatWithMobile" class="text-sm text-gray-400 truncate">No chat selected</div>
            </div>
        </div>
        <div class="flex-none mt-2 sm:mt-0">
            <span class="mr-4 text-sm opacity-70">Hello, <strong><?= $username ?></strong></span>
        </div>
        <button onclick="toggleSidebar()" class="btn btn-square btn-sm btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Main Section -->
    <div class="flex flex-col lg:flex-row-reverse flex-1 overflow-hidden">
        
        <!-- Sidebar (right on desktop, full width on mobile) -->
     <aside
    id="sidebar"
    class="transition-all duration-300 ease-in-out 
                 w-full lg:w-72 bg-base-300 p-4 border-r border-base-content 
                 overflow-y-auto fixed inset-0 z-40 lg:relative lg:block hidden">

            <div class="flex justify-between items-center mb-4">
                <div class="tabs tabs-boxed text-xs w-full">
                    <a id="tabGroups" class="tab tab-active w-1/2" onclick="showTab('groups')">Chats</a>
                    <a id="tabUsers" class="tab w-1/2" onclick="showTab('users')">Contacts</a>
                </div>
            </div>

            <!-- Group Chats List -->
            <ul id="chatList" class="space-y-2"></ul>

            <!-- Users List -->
            <ul id="userList" class="space-y-2 hidden"></ul>

            <!-- Create Group Button -->
            <label for="createChatModal" class="btn btn-xs btn-primary mt-4 w-full" onclick="showCreateChat()">+ New Group</label>

            <!-- Logout for Mobile -->
        <a href="logout.php" class="btn btn-sm btn-ghost mt-4 w-full lg:hidden text-gray-400 flex items-center justify-center gap-2">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            Logout
        </a>
        </aside>

        <!-- Main Chat Area -->
        <main class="flex-1 flex flex-col">
            <!-- Desktop Navbar -->
            <div class="hidden lg:flex navbar bg-base-300 border-b border-base-content px-4 py-2">
                <div class="flex-1 min-w-0">
                    <div class="text-left">
                        <div class="text-lg font-semibold truncate">Astra Desk</div>
                        <div id="chatWith" class="text-sm text-gray-400 truncate">No chat selected</div>
                    </div>
                </div>
                <div class="flex-none">
                    <span class="mr-4 text-sm opacity-70">Hello, <strong><?= $username ?></strong></span>
                    <a href="logout.php" class="btn btn-sm bg-ghost  flex items-center gap-2">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        Logout
                    </a>
                </div>
            </div>

            <!-- Chat Box -->
         <div id="chatBox" class="flex-1 overflow-y-auto p-4 space-y-4 bg-base-100 max-h-[calc(100vh-200px)]"></div>


            <!-- Chat Input -->
            <form id="chatForm" class="p-3 bg-base-300 border-t border-base-content flex gap-2 sticky bottom-0 z-10">
                <input
                    type="text"
                    id="messageInput"
                    placeholder="Type a message..."
                    class="input input-bordered w-full bg-base-100 text-white"
                    required
                />
                <button type="submit" class="btn btn-primary">Send</button>
            </form>
        </main>
    </div>

    <!-- Create Group Modal (centered) -->
    <input type="checkbox" id="createChatModal" class="modal-toggle" />
    <div class="modal modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-2">Create a New Group</h3>
            <input id="chatName" placeholder="Group name" class="input input-bordered w-full mb-3 bg-base-100 text-white" />
            <div id="userCheckboxList" class="space-y-2 max-h-48 overflow-y-auto p-2 border rounded bg-base-200">
                <!-- Checkboxes will be added here -->
            </div>
            <div class="modal-action">
                <label for="createChatModal" class="btn btn-error">Cancel</label>
                <button type="button" onclick="createChat()" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</div>




<script>
let currentConversationId = null;

/// Load list of existing chats (private or group)
async function loadChats() {
  const res = await fetch('fetch_conversations.php');
  const conversations = await res.json();
  const chatList = document.getElementById('chatList');
  chatList.innerHTML = '';

  conversations.forEach(chat => {
    const hasUnread = chat.unread_count && chat.unread_count > 0;
    const isPrivate = !chat.is_group;
    const chatName = chat.name || chat.members;

    const item = document.createElement('li');
    item.className = 'flex items-center justify-between p-2 bg-base-100 rounded hover:bg-base-200 cursor-pointer';

    const nameWrapper = document.createElement('div');
    nameWrapper.className = 'truncate max-w-[80%] font-semibold flex items-center gap-2';

    nameWrapper.innerHTML = `
      <span>${chatName}</span>
      ${isPrivate ? `<span class="badge badge-xs ${chat.online ? 'badge-success' : 'badge-error'}" title="${chat.online ? 'Online' : 'Offline'}"></span>` : ''}
    `;

    item.appendChild(nameWrapper);

    if (hasUnread) {
      const badge = document.createElement('span');
      badge.className = 'badge badge-error badge-sm';
      badge.textContent = chat.unread_count;
      item.appendChild(badge);
    }

    item.onclick = () => {
      currentConversationId = chat.id;

      // Update both mobile and desktop headers
      document.getElementById('chatWith').textContent = `${chatName}`;
      const mobileHeader = document.getElementById('chatWithMobile');
      if (mobileHeader) {
        mobileHeader.textContent = `${chatName}`;
      }

      loadMessages();
      markMessagesAsRead(chat.id);
      hideSidebarOnMobile();
    };

    chatList.appendChild(item);
  });
}

// Load users for starting private chats
async function loadUsers() {
  const res = await fetch('fetch_users.php');
  const json = await res.json();
  const users = json.users || [];
  const userList = document.getElementById('userList');
  userList.innerHTML = '';

  users.forEach(user => {
    const hasUnread = user.unread_count && user.unread_count > 0;
    const item = document.createElement('li');
    item.className = 'flex items-center justify-between p-2 bg-base-100 rounded hover:bg-base-200 cursor-pointer';
    item.innerHTML = `
      <div class="truncate max-w-[70%]">
        <span class="font-medium">${user.username}</span>
        <span class="text-xs text-gray-400 block">${user.online ? 'Online' : 'Offline'}</span>
      </div>
      ${hasUnread ? `<span class="badge badge-error badge-sm">${user.unread_count}</span>` : ''}
    `;

    item.onclick = async () => {
      const res = await fetch('start_private_chat.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ user_id: user.id })
      });

      const data = await res.json();
      if (data.status === 'success') {
        currentConversationId = data.conversation_id;

        // Update chat headings
        document.getElementById('chatWith').textContent = user.username;
        document.getElementById('chatWithMobile').textContent = user.username;

        // Show messages
        loadMessages();

        // Switch to chat tab
        showTab('groups');

        // Hide sidebar on mobile
        hideSidebarOnMobile();
      }
    };

    userList.appendChild(item);
  });
}



// Load messages for selected conversation
let lastMessageId = null;

async function loadMessages() {
  if (!currentConversationId) return;

  const res = await fetch(`fetch_messages.php?conversation_id=${currentConversationId}`);
  const messages = await res.json();

  const chatBox = document.getElementById('chatBox');
  const previousLastId = lastMessageId;

  chatBox.innerHTML = '';

  messages.forEach(msg => {
    const side = msg.is_self ? 'chat-end' : 'chat-start';
    const color = msg.is_self ? 'bg-primary' : 'bg-neutral';
    const bubble = document.createElement('div');
    bubble.className = `chat ${side}`;
    bubble.innerHTML = `
      <div class="chat-bubble ${color} text-white max-w-[80%]">
        <div class="text-xs opacity-70 mb-1">${msg.username} • ${new Date(msg.created_at).toLocaleTimeString()}</div>
        <div class="text-sm">${msg.message}</div>
      </div>`;
    chatBox.appendChild(bubble);
  });

  // Check if last message changed
  if (messages.length) {
    const newLastId = messages[messages.length - 1].id;
    if (newLastId !== previousLastId) {
      chatBox.scrollTop = chatBox.scrollHeight; // only scroll if new message exists
    }
    lastMessageId = newLastId;
  }
}


// Send message
document.getElementById('chatForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const input = document.getElementById('messageInput');
  const message = input.value.trim();
  if (!message || !currentConversationId) return;

  const res = await fetch('send_message.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({
      message,
      conversation_id: currentConversationId
    })
  });

  const data = await res.json();
  if (data.status === 'success') {
    input.value = '';
    loadMessages();
  }
});

// Populate user list in group modal
async function showCreateChat() {
  const res = await fetch('fetch_users.php');
  const json = await res.json();
  const users = json.users || [];
  const list = document.getElementById('userCheckboxList');
  list.innerHTML = '';

  users.forEach(user => {
    list.innerHTML += `
      <label class="flex items-center space-x-2">
        <input type="checkbox" value="${user.id}" class="checkbox user-check" />
        <span>${user.username}</span>
      </label>`;
  });
}

// Create group chat
async function createChat() {
  const name = document.getElementById('chatName').value.trim();
  const selected = [...document.querySelectorAll('.user-check:checked')].map(cb => cb.value);

  if (!name || selected.length < 1) {
    alert('Group name and at least 1 member required.');
    return;
  }

  const res = await fetch('create_chat.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({
      name,
      members: JSON.stringify(selected)
    })
  });

  const data = await res.json();
  if (data.status === 'success') {
    currentConversationId = data.conversation_id;
    document.getElementById('createChatModal').checked = false;
    loadChats();
    loadMessages();
  } else {
    alert(data.message || 'Failed to create chat');
  }
}

// Optional: mark messages as read
async function markMessagesAsRead(conversationId) {
  await fetch('mark_as_read.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ conversation_id: conversationId })
  });
}

// Switch tabs between groups and users
function showTab(tab) {
  document.getElementById('chatList').classList.toggle('hidden', tab !== 'groups');
  document.getElementById('userList').classList.toggle('hidden', tab !== 'users');
  document.getElementById('tabGroups').classList.toggle('tab-active', tab === 'groups');
  document.getElementById('tabUsers').classList.toggle('tab-active', tab === 'users');
}

// Mobile sidebar toggle
function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  sidebar.classList.toggle('hidden');
}

// Polling every 3 seconds
setInterval(() => {
  if (currentConversationId) loadMessages();
  loadChats();
}, 3000);

// Initial load
loadChats();
loadUsers();
</script>



<script>
function showTab(tab) {
    const tabUsers = document.getElementById('tabUsers');
    const tabGroups = document.getElementById('tabGroups');
    const userList = document.getElementById('userList');
    const chatList = document.getElementById('chatList');

    if (tab === 'users') {
        tabUsers.classList.add('tab-active');
        tabGroups.classList.remove('tab-active');
        userList.classList.remove('hidden');
        chatList.classList.add('hidden');
        document.getElementById('chatWith').textContent = 'No chat selected';
        document.getElementById('chatWithMobile').textContent = 'No chat selected';
    } else {
        tabGroups.classList.add('tab-active');
        tabUsers.classList.remove('tab-active');
        userList.classList.add('hidden');
        chatList.classList.remove('hidden');
    }
}

// Hide sidebar on small screens
function hideSidebarOnMobile() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.add('hidden');
}

// On page load
document.addEventListener('DOMContentLoaded', () => {
    showTab('users');
    document.getElementById('tabGroups').classList.remove('tab-active');
    document.getElementById('tabUsers').classList.remove('tab-active');
    document.getElementById('chatList').classList.add('hidden');
    document.getElementById('userList').classList.add('hidden');
    document.getElementById('chatWith').textContent = 'No chat selected';
    document.getElementById('chatWithMobile').textContent = 'No chat selected';
});
</script>


</body>
</html>

