@php
    $phone = '01334958490';
    try {
        if (function_exists('get_settings') && get_settings('phone')) {
            $phone = get_settings('phone');
        }
    } catch (\Throwable $e) {}

    // Clean phone number for WhatsApp URL (e.g. 8801334958490)
    $clean_phone = preg_replace('/[^0-9]/', '', $phone);
    if (!str_starts_with($clean_phone, '88')) {
        $clean_phone = '88' . $clean_phone;
    }
@endphp

<!-- FLOATING WHATSAPP & AI CHATBOT WIDGET -->
<div id="hosen-ai-widget-container">

    <!-- 1. Floating WhatsApp Button (Clean "WhatsApp" Label - No raw phone number displayed) -->
    <a href="https://wa.me/{{ $clean_phone }}" target="_blank" id="hosen-whatsapp-btn" aria-label="WhatsApp">
        <i class="fa-brands fa-whatsapp wa-icon"></i>
        <span class="wa-label">WhatsApp</span>
    </a>

    <!-- 2. Floating AI Chatbot Trigger Button (Minimal, Modern, Premium Icon) -->
    <button type="button" id="hosen-ai-trigger-btn" aria-label="{{ get_phrase('Ask Hosen Academy AI') }}">
        <div class="ai-btn-inner">
            <span class="icon-open-wrapper">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.477 2 2 6.477 2 12C2 13.82 2.487 15.527 3.338 17L2 22L7 20.662C8.473 21.513 10.18 22 12 22C17.523 22 22 17.523 22 12C22 6.477 17.523 2 12 2Z" fill="white" opacity="0.2"/>
                    <path d="M12 4C7.582 4 4 7.582 4 12C4 13.456 4.39 14.82 5.07 16L4 20L8 18.93C9.18 19.61 10.544 20 12 20C16.418 20 20 16.418 20 12C20 7.582 16.418 4 12 4Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="8.5" cy="11.5" r="1.25" fill="white"/>
                    <circle cx="12" cy="11.5" r="1.25" fill="white"/>
                    <circle cx="15.5" cy="11.5" r="1.25" fill="white"/>
                    <path d="M17.5 5L18.1 6.4L19.5 7L18.1 7.6L17.5 9L16.9 7.6L15.5 7L16.9 6.4L17.5 5Z" fill="#FBBF24"/>
                </svg>
            </span>
            <i class="fa-solid fa-xmark icon-close"></i>
        </div>
        <span class="ai-btn-badge">AI</span>
    </button>

    <!-- 3. AI Chatbot Window Popup -->
    <div id="hosen-ai-chat-window">
        <!-- Header -->
        <div class="ai-chat-header">
            <div class="d-flex align-items-center gap-3">
                <div class="ai-avatar-wrap">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.477 2 2 6.477 2 12C2 13.82 2.487 15.527 3.338 17L2 22L7 20.662C8.473 21.513 10.18 22 12 22C17.523 22 22 17.523 22 12C22 6.477 17.523 2 12 2Z" fill="white" opacity="0.3"/>
                        <path d="M12 4C7.582 4 4 7.582 4 12C4 13.456 4.39 14.82 5.07 16L4 20L8 18.93C9.18 19.61 10.544 20 12 20C16.418 20 20 16.418 20 12C20 7.582 16.418 4 12 4Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="8.5" cy="11.5" r="1.25" fill="white"/>
                        <circle cx="12" cy="11.5" r="1.25" fill="white"/>
                        <circle cx="15.5" cy="11.5" r="1.25" fill="white"/>
                    </svg>
                    <span class="online-indicator"></span>
                </div>
                <div>
                    <h5 class="ai-title mb-0">Hosen Academy AI</h5>
                    <span class="ai-subtitle"><i class="fa-solid fa-bolt text-warning me-1"></i>{{ get_phrase('Online • Always Available') }}</span>
                </div>
            </div>
            <button type="button" class="ai-close-btn" id="hosen-ai-close-btn" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Quick Suggestion Chips (FontAwesome Icons - No Raw Emojis) -->
        <div class="ai-chips-bar">
            <button type="button" class="ai-chip-btn" data-prompt="হোসেন একাডেমিতে কি কি কোর্স আছে?"><i class="fa-solid fa-graduation-cap text-indigo me-1"></i>Courses</button>
            <button type="button" class="ai-chip-btn" data-prompt="ওয়েবসাইট ও সফটওয়্যার ডেভেলপমেন্ট সার্ভিস সম্পর্কে বলুন।"><i class="fa-solid fa-code text-indigo me-1"></i>Software Dev</button>
            <button type="button" class="ai-chip-btn" data-prompt="মোবাইল অ্যাপ ডেভেলপমেন্ট সেবা সম্পর্কে জানতে চাই।"><i class="fa-solid fa-mobile-screen text-indigo me-1"></i>App Dev</button>
            <button type="button" class="ai-chip-btn" data-prompt="eBooks ও স্টাডি মেটেরিয়াল কি কি আছে?"><i class="fa-solid fa-book text-indigo me-1"></i>eBooks</button>
        </div>

        <!-- Chat Body / Messages Area -->
        <div class="ai-chat-body" id="hosen-ai-chat-body">
            <!-- Initial Welcome Message (No Emojis) -->
            <div class="ai-msg ai-msg-bot">
                <div class="msg-bubble">
                    <p class="mb-0">আসসালামু আলাইকুম! আমি <strong>হোসেন একাডেমি এআই অ্যাসিস্ট্যান্ট</strong>।</p>
                    <p class="mt-2 mb-0">আমাদের কোর্স, ইবুক, ওয়েবসাইট ও অ্যাপ ডেভেলপমেন্ট সফটওয়্যার সার্ভিস সম্পর্কে কোনো প্রশ্ন থাকলে জানান। আমি আপনাকে সাহায্য করতে প্রস্তুত!</p>
                    <p class="mt-2 mb-0 text-muted text-xs"><em>If you have any questions about our courses, eBooks, or software development, feel free to ask!</em></p>
                </div>
                <span class="msg-time">{{ date('h:i A') }}</span>
            </div>
        </div>

        <!-- Typing Indicator -->
        <div class="ai-typing-indicator d-none" id="hosen-ai-typing">
            <div class="typing-bubble">
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>
            <span class="typing-text">Hosen AI is thinking...</span>
        </div>

        <!-- Input Footer -->
        <div class="ai-chat-footer">
            <form id="hosen-ai-chat-form" onsubmit="return false;">
                @csrf
                <div class="input-group align-items-center">
                    <input type="text" id="hosen-ai-user-input" class="form-control" placeholder="{{ get_phrase('Ask anything about courses, software, ebooks...') }}" autocomplete="off" required>
                    <button type="submit" id="hosen-ai-send-btn" class="btn btn-indigo">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
            </form>
            <div class="ai-footer-note">
                <span>Powered by <a href="https://hosen-software-shop.solutionsquad.tech" target="_blank" class="fw-bold text-indigo text-decoration-none">Hosen Software Shop</a> • <a href="https://wa.me/{{ $clean_phone }}" target="_blank" class="text-success fw-bold text-decoration-none"><i class="fa-brands fa-whatsapp me-1"></i>WhatsApp Support</a></span>
            </div>
        </div>
    </div>
</div>

<!-- AI CHATBOT STYLES -->
<style>
/* 1. Floating Container */
#hosen-ai-widget-container {
    position: fixed;
    bottom: 0;
    right: 0;
    z-index: 1045;
    font-family: var(--font-family, 'Inter', system-ui, -apple-system, sans-serif);
}

/* 2. Floating WhatsApp Button (Clean Pill Badge - No Raw Phone Number Text) */
#hosen-whatsapp-btn {
    position: fixed;
    bottom: 95px;
    right: 28px;
    padding: 10px 18px;
    border-radius: 50px;
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    color: #ffffff;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 0.3px;
    box-shadow: 0 8px 25px rgba(37, 211, 102, 0.35);
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    z-index: 1045;
    text-decoration: none;
}

#hosen-whatsapp-btn .wa-icon {
    font-size: 20px;
}

#hosen-whatsapp-btn .wa-label {
    font-size: 13.5px;
    font-weight: 700;
}

#hosen-whatsapp-btn:hover {
    transform: translateY(-3px) scale(1.04);
    color: #ffffff;
    box-shadow: 0 12px 30px rgba(37, 211, 102, 0.55);
}

/* 3. Floating AI Trigger Button (Minimal, Modern Icon) */
#hosen-ai-trigger-btn {
    position: fixed;
    bottom: 28px;
    right: 28px;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    color: #ffffff;
    border: none;
    outline: none;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 28px rgba(79, 70, 229, 0.45);
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    z-index: 1046;
}

#hosen-ai-trigger-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 14px 35px rgba(79, 70, 229, 0.6);
}

.ai-btn-inner {
    position: relative;
    width: 26px;
    height: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon-open-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease;
}

.ai-btn-inner .icon-close {
    display: none;
    font-size: 22px;
}

#hosen-ai-widget-container.active #hosen-ai-trigger-btn .icon-open-wrapper {
    display: none;
}

#hosen-ai-widget-container.active #hosen-ai-trigger-btn .icon-close {
    display: block;
}

.ai-btn-badge {
    position: absolute;
    top: -2px;
    right: -2px;
    background: #ef4444;
    color: #ffffff;
    font-size: 10px;
    font-weight: 800;
    padding: 2px 6px;
    border-radius: 50px;
    border: 2px solid #ffffff;
}

/* 4. AI Chat Window Popup */
#hosen-ai-chat-window {
    position: fixed;
    bottom: 96px;
    right: 28px;
    width: 380px;
    max-width: calc(100vw - 36px);
    height: 560px;
    max-height: calc(100vh - 120px);
    background: #ffffff;
    border-radius: 22px;
    border: 1px solid rgba(226, 232, 240, 0.9);
    box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.25), 0 0 20px rgba(79, 70, 229, 0.08);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    z-index: 1050;
    opacity: 0;
    visibility: hidden;
    transform: translateY(20px) scale(0.95);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

#hosen-ai-widget-container.active #hosen-ai-chat-window {
    opacity: 1;
    visibility: visible;
    transform: translateY(0) scale(1);
}

@media (min-width: 992px) {
    #hosen-ai-chat-window {
        width: 440px !important;
        height: 640px !important;
        max-height: calc(100vh - 110px) !important;
        right: 32px !important;
        bottom: 100px !important;
    }
}

/* Header */
.ai-chat-header {
    background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
    color: #ffffff;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.ai-avatar-wrap {
    position: relative;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
}

.online-indicator {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 11px;
    height: 11px;
    border-radius: 50%;
    background: #10b981;
    border: 2px solid #ffffff;
}

.ai-title {
    font-size: 16px;
    font-weight: 700;
    color: #ffffff;
    line-height: 1.2;
}

.ai-subtitle {
    font-size: 11px;
    color: rgba(255, 255, 255, 0.85);
}

.ai-close-btn {
    background: transparent;
    border: none;
    color: #ffffff;
    font-size: 18px;
    cursor: pointer;
    opacity: 0.85;
    transition: opacity 0.2s ease;
}

.ai-close-btn:hover {
    opacity: 1;
}

/* Chips Bar */
.ai-chips-bar {
    padding: 10px 14px;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    gap: 6px;
    overflow-x: auto;
    scrollbar-width: none;
}

.ai-chips-bar::-webkit-scrollbar {
    display: none;
}

.ai-chip-btn {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #334155;
    font-size: 12px;
    font-weight: 600;
    padding: 5px 12px;
    border-radius: 50px;
    white-space: nowrap;
    cursor: pointer;
    transition: all 0.2s ease;
}

.ai-chip-btn:hover {
    background: #4f46e5;
    border-color: #4f46e5;
    color: #ffffff;
}

/* Messages Body */
.ai-chat-body {
    flex: 1;
    padding: 16px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 14px;
    background: #fafafa;
}

.ai-msg {
    display: flex;
    flex-direction: column;
    max-width: 85%;
}

.ai-msg-bot {
    align-self: flex-start;
}

.ai-msg-user {
    align-self: flex-end;
}

.msg-bubble {
    padding: 12px 16px;
    font-size: 13.5px;
    line-height: 1.5;
    border-radius: 18px;
}

.ai-msg-bot .msg-bubble {
    background: #ffffff;
    color: #0f172a;
    border: 1px solid #e2e8f0;
    border-top-left-radius: 4px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.ai-msg-user .msg-bubble {
    background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
    color: #ffffff;
    border-top-right-radius: 4px;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
}

.msg-time {
    font-size: 10px;
    color: #94a3b8;
    margin-top: 4px;
    padding: 0 4px;
}

.ai-msg-user .msg-time {
    text-align: right;
}

/* Typing Indicator */
.ai-typing-indicator {
    padding: 10px 16px;
    display: flex;
    align-items: center;
    gap: 8px;
    background: #fafafa;
}

.typing-bubble {
    background: #ffffff;
    padding: 8px 12px;
    border-radius: 18px;
    border: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 4px;
}

.typing-bubble .dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #4f46e5;
    animation: typingPulse 1.4s infinite ease-in-out;
}

.typing-bubble .dot:nth-child(2) { animation-delay: 0.2s; }
.typing-bubble .dot:nth-child(3) { animation-delay: 0.4s; }

@keyframes typingPulse {
    0%, 60%, 100% { transform: translateY(0); opacity: 0.4; }
    30% { transform: translateY(-4px); opacity: 1; }
}

.typing-text {
    font-size: 11px;
    color: #64748b;
}

/* Footer Input */
.ai-chat-footer {
    padding: 12px 14px;
    background: #ffffff;
    border-top: 1px solid #e2e8f0;
}

.ai-chat-footer .input-group {
    background: #f1f5f9;
    border-radius: 50px;
    padding: 4px;
    border: 1px solid #e2e8f0;
    transition: border-color 0.2s ease;
}

.ai-chat-footer .input-group:focus-within {
    border-color: #6366f1;
    background: #ffffff;
}

.ai-chat-footer .form-control {
    background: transparent;
    border: none;
    box-shadow: none;
    font-size: 13.5px;
    padding: 8px 16px;
    color: #0f172a;
}

.ai-chat-footer .btn-indigo {
    background: #4f46e5;
    color: #ffffff;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    border: none;
    transition: transform 0.2s ease;
}

.ai-chat-footer .btn-indigo:hover {
    transform: scale(1.08);
}

.ai-footer-note {
    text-align: center;
    font-size: 10px;
    color: #94a3b8;
    margin-top: 8px;
}

@media (max-width: 576px) {
    #hosen-ai-chat-window {
        right: 18px;
        bottom: 86px;
        width: calc(100vw - 36px);
        height: 500px;
    }
    #hosen-ai-trigger-btn { right: 18px; bottom: 20px; }
    #hosen-whatsapp-btn { right: 18px; bottom: 84px; }
}
</style>

<!-- AI CHATBOT SCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("hosen-ai-widget-container");
    const triggerBtn = document.getElementById("hosen-ai-trigger-btn");
    const closeBtn = document.getElementById("hosen-ai-close-btn");
    const chatForm = document.getElementById("hosen-ai-chat-form");
    const userInput = document.getElementById("hosen-ai-user-input");
    const chatBody = document.getElementById("hosen-ai-chat-body");
    const typingIndicator = document.getElementById("hosen-ai-typing");
    const chipBtns = document.querySelectorAll(".ai-chip-btn");

    let chatHistory = [];

    // Toggle Chat Window
    function toggleChat() {
        container.classList.toggle("active");
        if (container.classList.contains("active")) {
            userInput.focus();
        }
    }

    triggerBtn.addEventListener("click", toggleChat);
    closeBtn.addEventListener("click", toggleChat);

    // Quick Chips click
    chipBtns.forEach(btn => {
        btn.addEventListener("click", function () {
            const promptText = this.getAttribute("data-prompt");
            userInput.value = promptText;
            sendMessage();
        });
    });

    // Form Submit
    chatForm.addEventListener("submit", function (e) {
        e.preventDefault();
        sendMessage();
    });

    function sendMessage() {
        const text = userInput.value.trim();
        if (!text) return;

        // Append User Message
        appendMessage("user", text);
        userInput.value = "";

        // Show typing indicator
        showTyping(true);
        scrollToBottom();

        // Send AJAX request to Laravel Controller
        fetch("{{ route('ai.chatbot.send') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                message: text,
                history: chatHistory
            })
        })
        .then(res => res.json())
        .then(data => {
            showTyping(false);
            if (data.status === "success" && data.reply) {
                appendMessage("bot", data.reply);
                // Maintain history context
                chatHistory.push({ role: "user", content: text });
                chatHistory.push({ role: "model", content: data.reply });
                if (chatHistory.length > 10) chatHistory.shift();
            } else {
                appendMessage("bot", "দুঃখিত, বর্তমানে এআই সার্ভারে কিছুটা সমস্যা হচ্ছে। অনুগ্রহ করে কিছু পর আবার চেষ্টা করুন অথবা আমাদের হোয়াটসঅ্যাপে যোগাযোগ করুন (01334958490)।");
            }
        })
        .catch(err => {
            showTyping(false);
            appendMessage("bot", "দুঃখিত, সংযোগে সমস্যা হয়েছে। অনুগ্রহ করে ইন্টারনেট কানেকশন চেক করুন অথবা আমাদের হোয়াটসঅ্যাপে যোগাযোগ করুন (01334958490)।");
        });
    }

    function appendMessage(sender, messageText) {
        const timeStr = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        const msgDiv = document.createElement("div");
        msgDiv.className = `ai-msg ai-msg-${sender}`;

        // Format linebreaks and bold text
        let formattedContent = escapeHtml(messageText)
            .replace(/\n/g, '<br>')
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');

        msgDiv.innerHTML = `
            <div class="msg-bubble">
                <p class="mb-0">${formattedContent}</p>
            </div>
            <span class="msg-time">${timeStr}</span>
        `;

        chatBody.appendChild(msgDiv);
        scrollToBottom();
    }

    function showTyping(show) {
        if (show) {
            typingIndicator.classList.remove("d-none");
        } else {
            typingIndicator.classList.add("d-none");
        }
    }

    function scrollToBottom() {
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    function escapeHtml(string) {
        return String(string).replace(/[&<>"']/g, function (s) {
            return {
                "&": "&amp;",
                "<": "&lt;",
                ">": "&gt;",
                '"': "&quot;",
                "'": "&#39;"
            }[s];
        });
    }
});
</script>
