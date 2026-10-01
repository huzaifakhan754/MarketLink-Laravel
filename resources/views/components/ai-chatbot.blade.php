{{-- =========================================================
     MARKETLINK AI CHATBOT
     Reusable component
========================================================= --}}

@auth

<style>
    /* =========================
       AI CHATBOT
    ========================= */

    #mlAiWindow {
        animation: mlAiOpen .22s ease-out;
    }

    @keyframes mlAiOpen {
        from {
            opacity: 0;
            transform: translateY(15px) scale(.97);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    #mlAiMessages::-webkit-scrollbar {
        width: 5px;
    }

    #mlAiMessages::-webkit-scrollbar-track {
        background: transparent;
    }

    #mlAiMessages::-webkit-scrollbar-thumb {
        background: #c9c9c9;
        border-radius: 20px;
    }

    /* =========================
       MESSAGE BUBBLE
    ========================= */

    .ml-ai-message-wrapper {
        width: fit-content;
        max-width: 72%;
    }

    .ml-ai-bubble {
        display: block;
        width: fit-content;
        max-width: 100%;
        box-sizing: border-box;

        padding: 8px 11px !important;

        border-radius: 14px !important;

        word-break: break-word;
        overflow-wrap: anywhere;

        font-size: 12px !important;
        line-height: 1.45 !important;
    }

    .ml-ai-bubble p {
        margin: 0 !important;
        padding: 0 !important;

        font-size: 12px !important;
        line-height: 1.45 !important;
    }

    .ml-ai-message-time {
        font-size: 9px;
        margin-top: 4px;
        opacity: .65;
        line-height: 1;
    }

    /* =========================
       WELCOME MESSAGE
    ========================= */

    #mlAiWelcomeMessage .ml-ai-message-wrapper {
        max-width: 76%;
    }

    #mlAiWelcomeMessage .ml-ai-bubble {
        padding: 9px 12px !important;
    }

    #mlAiWelcomeMessage .ml-ai-bubble p {
        font-size: 12px !important;
        line-height: 1.5 !important;
    }

    /* =========================
       QUICK BUTTONS
    ========================= */

    .ml-ai-quick-btn {
        transition: all .18s ease;
    }

    .ml-ai-quick-btn:hover {
        transform: translateY(-1px);
        background: #005327;
        color: white;
    }

    /* =========================
       INPUT
    ========================= */

    #mlAiInput {
        resize: none;
        min-height: 52px;
        max-height: 120px;
    }

    #mlAiInput:disabled {
        opacity: .65;
        cursor: not-allowed;
    }

    /* =========================
       MOBILE
    ========================= */

    @media (max-width: 640px) {

        #mlAiWindow {
            right: 12px !important;
            left: 12px !important;
            bottom: 12px !important;
            width: auto !important;
            height: calc(100vh - 90px) !important;
            max-height: none !important;
            border-radius: 24px !important;
        }

        #mlAiMessages {
            height: calc(100% - 165px) !important;
        }

        #mlAiOpenButton {
            right: 18px !important;
            bottom: 18px !important;
        }

        .ml-ai-message-wrapper {
            max-width: 82%;
        }

        .ml-ai-bubble {
            padding: 8px 10px !important;
            border-radius: 13px !important;
        }

        .ml-ai-bubble p {
            font-size: 12px !important;
            line-height: 1.45 !important;
        }

        #mlAiWelcomeMessage .ml-ai-message-wrapper {
            max-width: 86%;
        }
    }
</style>


<div id="marketLinkAI">

    {{-- =====================================================
         FLOATING BUTTON
    ====================================================== --}}

    <button
        id="mlAiOpenButton"
        type="button"
        aria-label="Open MarketLink AI"
        class="fixed
               bottom-6
               right-6
               z-[9999]
               flex
               h-[62px]
               w-[62px]
               items-center
               justify-center
               rounded-full
               bg-[#005327]
               text-white
               shadow-[0_12px_35px_rgba(0,83,39,.30)]
               transition-all
               duration-200
               hover:scale-105
               hover:bg-[#073F24]">

        <i class="fa-solid fa-robot text-[24px]"></i>

        <span
            class="absolute
                   right-1
                   top-1
                   h-3
                   w-3
                   rounded-full
                   border-2
                   border-white
                   bg-green-400">
        </span>

    </button>


    {{-- =====================================================
         CHAT WINDOW
    ====================================================== --}}

    <div
        id="mlAiWindow"
        class="hidden
               fixed
               bottom-6
               right-6
               z-[9998]
               flex
               h-[680px]
               max-h-[85vh]
               w-[430px]
               max-w-[calc(100vw-24px)]
               flex-col
               overflow-hidden
               rounded-[28px]
               border
               border-gray-200
               bg-white
               shadow-[0_25px_70px_rgba(0,0,0,.18)]">


        {{-- =================================================
             HEADER
        ================================================== --}}

        <div
            class="shrink-0
                   bg-[#005327]
                   px-5
                   py-4
                   text-white">

            <div class="flex items-center justify-between">

                <div class="flex items-center gap-3">

                    <div
                        class="flex
                               h-12
                               w-12
                               items-center
                               justify-center
                               rounded-2xl
                               bg-white/15">

                        <i class="fa-solid fa-robot text-xl"></i>

                    </div>

                    <div>

                        <div class="flex items-center gap-2">

                            <h3 class="text-[16px] font-bold">
                                MarketLink AI
                            </h3>

                            <span
                                class="rounded-full
                                       bg-green-400/20
                                       px-2
                                       py-0.5
                                       text-[9px]
                                       font-bold
                                       uppercase
                                       tracking-wide
                                       text-green-100">

                                Online

                            </span>

                        </div>

                        <p class="mt-0.5 text-xs text-white/70">
                            Your smart shopping assistant
                        </p>

                    </div>

                </div>


                <button
                    id="mlAiCloseButton"
                    type="button"
                    aria-label="Close chatbot"
                    class="flex
                           h-9
                           w-9
                           items-center
                           justify-center
                           rounded-full
                           text-white/80
                           transition
                           hover:bg-white/10
                           hover:text-white">

                    <i class="fa-solid fa-xmark text-lg"></i>

                </button>

            </div>

        </div>


        {{-- =================================================
             MESSAGES
        ================================================== --}}

        <div
            id="mlAiMessages"
            class="min-h-0
                   flex-1
                   overflow-y-auto
                   bg-[#FAF8F5]
                   px-4
                   py-5">


            {{-- =================================================
                 WELCOME MESSAGE
            ================================================== --}}

            <div
                id="mlAiWelcomeMessage"
                class="mb-4 flex justify-start">

                <div class="ml-ai-message-wrapper">

                    <div
                        class="ml-ai-bubble
                               rounded-2xl
                               rounded-tl-md
                               border
                               border-gray-200
                               bg-white
                               text-gray-700
                               shadow-sm">

                        <p class="font-semibold text-[#1C2826]">
                            👋 Assalamualaikum!
                        </p>

                        <p class="mt-1.5 text-gray-600">

                            Main <b class="text-[#005327]">MarketLink AI</b>
                            hoon. Aap mujhse Urdu ya English mein baat kar
                            sakte hain.

                        </p>

                        <p class="mt-1.5 text-gray-600">

                            Main pages open kar sakta hoon, products search
                            kar sakta hoon aur aapke cart mein items add kar
                            sakta hoon.

                        </p>

                    </div>

                    <div
                        class="ml-2
                               mt-1
                               text-[9px]
                               text-gray-400">

                        Just now

                    </div>

                </div>

            </div>


            {{-- =================================================
                 QUICK ACTIONS
            ================================================== --}}

            <div
                id="mlAiQuickActions"
                class="mb-4">

                <p
                    class="mb-2
                           px-1
                           text-[10px]
                           font-bold
                           uppercase
                           tracking-wider
                           text-gray-400">

                    Quick actions

                </p>


                <div class="grid grid-cols-2 gap-2">

                    <button
                        type="button"
                        class="ml-ai-quick-btn rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-left text-xs font-semibold text-gray-700 shadow-sm"
                        data-ai-command="market page kholo">

                        <i class="fa-solid fa-store mr-1.5 text-[#005327]"></i>
                        Markets

                    </button>

                    <button
                        type="button"
                        class="quick-action"
                        onclick="window.location.href='{{ route('smart-basket.index') }}'">
                        🧺 Create Smart Basket
                    </button>

                    <button
                        type="button"
                        class="ml-ai-quick-btn rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-left text-xs font-semibold text-gray-700 shadow-sm"
                        data-ai-command="products kholo">

                        <i class="fa-solid fa-leaf mr-1.5 text-[#005327]"></i>
                        Fresh Picks

                    </button>


                    <button
                        type="button"
                        class="ml-ai-quick-btn rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-left text-xs font-semibold text-gray-700 shadow-sm"
                        data-ai-command="cart kholo">

                        <i class="fa-solid fa-cart-shopping mr-1.5 text-[#CA6232]"></i>
                        My Cart

                    </button>


                    <button
                        type="button"
                        class="ml-ai-quick-btn rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-left text-xs font-semibold text-gray-700 shadow-sm"
                        data-ai-command="orders dikhao">

                        <i class="fa-solid fa-box mr-1.5 text-[#005327]"></i>
                        My Orders

                    </button>

                </div>

            </div>

        </div>


        {{-- =================================================
             TYPING INDICATOR
        ================================================== --}}

        <div
            id="mlAiTyping"
            class="hidden
                   shrink-0
                   bg-[#FAF8F5]
                   px-4
                   pb-2">

            <div
                class="inline-flex
                       items-center
                       gap-1.5
                       rounded-full
                       border
                       border-gray-200
                       bg-white
                       px-3.5
                       py-2
                       shadow-sm">

                <span
                    class="h-1.5
                           w-1.5
                           animate-bounce
                           rounded-full
                           bg-gray-400">
                </span>

                <span
                    class="h-1.5
                           w-1.5
                           animate-bounce
                           rounded-full
                           bg-gray-400"
                    style="animation-delay:150ms">
                </span>

                <span
                    class="h-1.5
                           w-1.5
                           animate-bounce
                           rounded-full
                           bg-gray-400"
                    style="animation-delay:300ms">
                </span>

                <span class="ml-1 text-[10px] text-gray-400">
                    AI is thinking...
                </span>

            </div>

        </div>


        {{-- =================================================
             INPUT
        ================================================== --}}

        <div
            class="shrink-0
                   border-t
                   border-gray-200
                   bg-white
                   p-3.5">

            <form
                id="mlAiForm"
                class="flex items-end gap-2">

                @csrf

                <div
                    class="min-w-0
                           flex-1
                           rounded-2xl
                           border
                           border-gray-200
                           bg-[#FAF8F5]
                           px-3.5
                           py-2
                           transition
                           focus-within:border-[#005327]/40
                           focus-within:ring-2
                           focus-within:ring-[#005327]/10">

                    <textarea
                        id="mlAiInput"
                        rows="1"
                        autocomplete="off"
                        placeholder="Type in English or Urdu..."
                        class="w-full
                               border-0
                               bg-transparent
                               px-0
                               py-1
                               text-[13px]
                               leading-6
                               text-gray-800
                               outline-none
                               placeholder:text-gray-400
                               focus:ring-0"></textarea>

                    <div class="mt-0.5 text-[9px] text-gray-400">
                        Example: "2 kg tomato cart mein add karo"
                    </div>

                </div>


                <button
                    type="submit"
                    aria-label="Send message"
                    class="flex
                           h-[54px]
                           w-[54px]
                           shrink-0
                           items-center
                           justify-center
                           rounded-2xl
                           bg-[#005327]
                           text-white
                           shadow-md
                           transition
                           hover:bg-[#073F24]
                           hover:shadow-lg
                           active:scale-95">

                    <i class="fa-solid fa-paper-plane text-sm"></i>

                </button>

            </form>

        </div>

    </div>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        const openButton =
            document.getElementById('mlAiOpenButton');

        const closeButton =
            document.getElementById('mlAiCloseButton');

        const chatWindow =
            document.getElementById('mlAiWindow');

        const form =
            document.getElementById('mlAiForm');

        const input =
            document.getElementById('mlAiInput');

        const messages =
            document.getElementById('mlAiMessages');

        const typing =
            document.getElementById('mlAiTyping');

        const welcomeMessage =
            document.getElementById('mlAiWelcomeMessage');

        const quickActions =
            document.getElementById('mlAiQuickActions');


        if (
            !openButton ||
            !closeButton ||
            !chatWindow ||
            !form ||
            !input ||
            !messages ||
            !typing
        ) {
            return;
        }


        /* =========================================================
           ROUTES
        ========================================================= */

        const AI_ROUTES = {

            markets: @json(route('markets')),

            products: @json(route('products')),

            cart: @json(route('cart.index')),

            checkout: @json(route('cart.checkout')),

            orders: @json(route('customer.orders'))

        };


        /* =========================================================
           LOCAL STORAGE
        ========================================================= */

        const AI_STORAGE_KEY =
            'marketlink_ai_chat_history_{{ auth()->id() }}';


        function getChatHistory() {

            try {

                const saved =
                    localStorage.getItem(
                        AI_STORAGE_KEY
                    );

                if (!saved) {
                    return [];
                }

                const parsed =
                    JSON.parse(saved);

                return Array.isArray(parsed) ?
                    parsed :
                    [];

            } catch (error) {

                console.error(
                    'MarketLink AI localStorage read error:',
                    error
                );

                return [];

            }

        }


        function saveChatMessage(
            text,
            type = 'ai',
            time = null
        ) {

            try {

                const history =
                    getChatHistory();

                history.push({

                    text: String(text || ''),

                    type: type,

                    time: time || getCurrentTime()

                });


                localStorage.setItem(
                    AI_STORAGE_KEY,
                    JSON.stringify(history)
                );

            } catch (error) {

                console.error(
                    'MarketLink AI localStorage save error:',
                    error
                );

            }

        }


        function clearChatHistory() {

            try {

                localStorage.removeItem(
                    AI_STORAGE_KEY
                );

            } catch (error) {

                console.error(
                    'MarketLink AI localStorage clear error:',
                    error
                );

            }

        }


        /* =========================================================
           CURRENT TIME
        ========================================================= */

        function getCurrentTime() {

            return new Date().toLocaleTimeString(
                [], {
                    hour: '2-digit',
                    minute: '2-digit'
                }
            );

        }


        /* =========================================================
           ESCAPE HTML
        ========================================================= */

        function escapeHtml(text) {

            const div =
                document.createElement('div');

            div.textContent =
                text;

            return div.innerHTML;

        }


        /* =========================================================
           SCROLL
        ========================================================= */

        function scrollToBottom() {

            messages.scrollTop =
                messages.scrollHeight;

        }


        /* =========================================================
           ADD MESSAGE
        ========================================================= */

        function addMessage(
            text,
            type = 'ai',
            save = true,
            savedTime = null
        ) {

            if (!text) {
                return;
            }


            const wrapper =
                document.createElement('div');


            const safeText =
                escapeHtml(text);


            const time =
                savedTime ||
                getCurrentTime();


            /* =====================================================
               USER MESSAGE
            ===================================================== */

            if (type === 'user') {

                wrapper.className =
                    'mb-3 flex justify-end';


                wrapper.innerHTML = `

                <div
                    class="ml-ai-message-wrapper
                           flex
                           flex-col
                           items-end">

                    <div
                        class="ml-ai-bubble
                               rounded-2xl
                               rounded-tr-md
                               bg-[#005327]
                               text-white
                               shadow-sm">

                        <p class="whitespace-pre-wrap">
                            ${safeText}
                        </p>

                    </div>


                    <div
                        class="mr-1
                               mt-1
                               text-right
                               text-[9px]
                               text-gray-400">

                        ${escapeHtml(time)}

                    </div>

                </div>

            `;

            }


            /* =====================================================
               AI MESSAGE
            ===================================================== */
            else {

                wrapper.className =
                    'mb-3 flex justify-start';


                wrapper.innerHTML = `

                <div
                    class="ml-ai-message-wrapper">

                    <div
                        class="ml-ai-bubble
                               rounded-2xl
                               rounded-tl-md
                               border
                               border-gray-200
                               bg-white
                               text-gray-700
                               shadow-sm">

                        <p class="whitespace-pre-wrap">
                            ${safeText}
                        </p>

                    </div>


                    <div
                        class="ml-1
                               mt-1
                               text-[9px]
                               text-gray-400">

                        ${escapeHtml(time)}

                    </div>

                </div>

            `;

            }


            messages.appendChild(
                wrapper
            );


            scrollToBottom();


            /* =====================================================
               SAVE
            ===================================================== */

            if (save) {

                saveChatMessage(
                    text,
                    type,
                    time
                );

            }

        }


        /* =========================================================
           LOAD CHAT HISTORY
        ========================================================= */

        function loadChatHistory() {

            const history =
                getChatHistory();


            if (history.length > 0) {

                messages.innerHTML = '';


                history.forEach(
                    function(item) {

                        if (
                            !item ||
                            typeof item.text ===
                            'undefined'
                        ) {
                            return;
                        }


                        addMessage(

                            item.text,

                            item.type ||
                            'ai',

                            false,

                            item.time ||
                            null

                        );

                    }
                );

            }


            scrollToBottom();

        }


        /* =========================================================
           OPEN CHAT
        ========================================================= */

        openButton.addEventListener(
            'click',
            function() {

                chatWindow.classList.remove(
                    'hidden'
                );

                openButton.classList.add(
                    'hidden'
                );


                setTimeout(
                    function() {

                        input.focus();

                        scrollToBottom();

                    },
                    100
                );

            }
        );


        /* =========================================================
           CLOSE CHAT
        ========================================================= */

        closeButton.addEventListener(
            'click',
            function() {

                chatWindow.classList.add(
                    'hidden'
                );

                openButton.classList.remove(
                    'hidden'
                );

            }
        );


        /* =========================================================
           PAGE COMMANDS
        ========================================================= */

        function handleAICommand(command) {

            const normalized =
                command
                .trim()
                .toUpperCase();


            /* =========================
               MARKETS
            ========================= */

            if (
                normalized.includes(
                    'OPEN_MARKETS'
                )
            ) {

                addMessage(
                    'Market page open kar raha hoon...'
                );


                setTimeout(
                    function() {

                        window.location.assign(
                            AI_ROUTES.markets
                        );

                    },
                    700
                );


                return true;
            }


            /* =========================
               PRODUCTS
            ========================= */

            if (
                normalized.includes(
                    'OPEN_PRODUCTS'
                )
            ) {

                addMessage(
                    'Products page open kar raha hoon...'
                );


                setTimeout(
                    function() {

                        window.location.assign(
                            AI_ROUTES.products
                        );

                    },
                    700
                );


                return true;
            }


            /* =========================
               CART
            ========================= */

            if (
                normalized.includes(
                    'OPEN_CART'
                )
            ) {

                addMessage(
                    'Cart open kar raha hoon...'
                );


                setTimeout(
                    function() {

                        window.location.assign(
                            AI_ROUTES.cart
                        );

                    },
                    700
                );


                return true;
            }


            /* =========================
               CHECKOUT
            ========================= */

            if (
                normalized.includes(
                    'OPEN_CHECKOUT'
                )
            ) {

                addMessage(
                    'Checkout open kar raha hoon...'
                );


                setTimeout(
                    function() {

                        window.location.assign(
                            AI_ROUTES.checkout
                        );

                    },
                    700
                );


                return true;
            }


            /* =========================
               ORDERS
            ========================= */

            if (
                normalized.includes(
                    'OPEN_ORDERS'
                )
            ) {

                addMessage(
                    'Orders open kar raha hoon...'
                );


                setTimeout(
                    function() {

                        window.location.assign(
                            AI_ROUTES.orders
                        );

                    },
                    700
                );


                return true;
            }


            return false;

        }


        /* =========================================================
           SEND MESSAGE
        ========================================================= */

        async function sendMessage(message) {

            if (
                !message ||
                input.disabled
            ) {
                return;
            }


            /* USER MESSAGE */

            addMessage(
                message,
                'user'
            );


            input.value = '';

            input.style.height =
                'auto';

            input.disabled =
                true;


            typing.classList.remove(
                'hidden'
            );


            scrollToBottom();


            try {

                const response =
                    await fetch(
                        "{{ route('ai.chat') }}", {

                            method: 'POST',

                            headers: {

                                'Content-Type': 'application/json',

                                'Accept': 'application/json',

                                'X-CSRF-TOKEN': document
                                    .querySelector(
                                        'meta[name="csrf-token"]'
                                    )
                                    ?.getAttribute(
                                        'content'
                                    ) ||
                                    "{{ csrf_token() }}"

                            },

                            body: JSON.stringify({
                                message: message
                            })

                        }
                    );


                let data = null;


                try {

                    data =
                        await response.json();

                } catch (jsonError) {

                    console.error(
                        'MarketLink AI invalid JSON response:',
                        jsonError
                    );

                }


                /* =================================================
                   API ERROR
                ================================================= */

                if (
                    !response.ok ||
                    !data ||
                    !data.success
                ) {

                    addMessage(

                        data?.message ||
                        'Sorry, AI se response nahi mila. Please try again.'

                    );

                    return;
                }


                /* =================================================
                   ADD TO CART
                ================================================= */

                if (
                    data.action ===
                    'OPEN_CART'
                ) {

                    if (data.message) {

                        addMessage(
                            data.message
                        );

                    }


                    setTimeout(
                        function() {

                            window.location.assign(
                                AI_ROUTES.cart
                            );

                        },
                        900
                    );


                    return;
                }


                /* =================================================
                   NORMAL AI RESPONSE
                ================================================= */

                const aiMessage =
                    (
                        data.message ||
                        ''
                    ).trim();


                /* =================================================
                   PAGE COMMAND
                ================================================= */

                if (
                    handleAICommand(
                        aiMessage
                    )
                ) {

                    return;

                }


                /* =================================================
                   NORMAL MESSAGE
                ================================================= */

                if (aiMessage) {

                    addMessage(
                        aiMessage
                    );

                } else {

                    addMessage(
                        'Mujhe samajh nahi aaya. Please dobara try karein.'
                    );

                }

            } catch (error) {

                console.error(
                    'MarketLink AI Error:',
                    error
                );


                addMessage(
                    'AI assistant se connection nahi ho saka. Please check your internet/API and try again.'
                );

            } finally {

                typing.classList.add(
                    'hidden'
                );

                input.disabled =
                    false;

                input.focus();

                scrollToBottom();

            }

        }


        /* =========================================================
           FORM SUBMIT
        ========================================================= */

        form.addEventListener(
            'submit',
            function(event) {

                event.preventDefault();


                const message =
                    input.value.trim();


                if (!message) {
                    return;
                }


                sendMessage(
                    message
                );

            }
        );


        /* =========================================================
           ENTER = SEND
           SHIFT + ENTER = NEW LINE
        ========================================================= */

        input.addEventListener(
            'keydown',
            function(event) {

                if (
                    event.key === 'Enter' &&
                    !event.shiftKey
                ) {

                    event.preventDefault();

                    form.requestSubmit();

                }

            }
        );


        /* =========================================================
           AUTO RESIZE TEXTAREA
        ========================================================= */

        input.addEventListener(
            'input',
            function() {

                this.style.height =
                    'auto';


                this.style.height =
                    Math.min(
                        this.scrollHeight,
                        120
                    ) + 'px';

            }
        );


        /* =========================================================
           QUICK ACTIONS
        ========================================================= */

        document
            .querySelectorAll(
                '[data-ai-command]'
            )
            .forEach(
                function(button) {

                    button.addEventListener(
                        'click',
                        function() {

                            const command =
                                this.getAttribute(
                                    'data-ai-command'
                                );


                            sendMessage(
                                command
                            );

                        }
                    );

                }
            );


        /* =========================================================
           LOAD SAVED CHAT
        ========================================================= */

        loadChatHistory();

    });
</script>

@endauth