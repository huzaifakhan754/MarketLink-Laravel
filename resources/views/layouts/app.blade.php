<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- =========================
     MARKETLINK AI CHATBOT
========================= -->

<div id="marketLinkAI">

    <!-- Floating AI Button -->
    <button
        id="aiOpenButton"
        type="button"
        class="fixed bottom-6 right-6 z-[9999]
               w-16 h-16 rounded-full
               bg-[#005327] text-white
               shadow-2xl
               flex items-center justify-center
               hover:scale-105 transition duration-200">

        <i class="fa-solid fa-robot text-2xl"></i>

    </button>


    <!-- Chat Window -->
    <div
        id="aiChatWindow"
        class="hidden fixed bottom-6 right-6 z-[9998]
               w-[380px] max-w-[calc(100vw-24px)]
               h-[600px] max-h-[80vh]
               bg-white rounded-3xl
               shadow-2xl
               border border-gray-200
               overflow-hidden">

        <!-- Header -->
        <div class="bg-[#005327] text-white px-5 py-4">

            <div class="flex items-center justify-between">

                <div class="flex items-center gap-3">

                    <div
                        class="w-11 h-11 rounded-full
                               bg-white/15
                               flex items-center justify-center">

                        <i class="fa-solid fa-robot text-xl"></i>

                    </div>

                    <div>

                        <h3 class="font-bold">
                            MarketLink AI
                        </h3>

                        <p class="text-xs text-white/70">
                            Your shopping assistant
                        </p>

                    </div>

                </div>


                <button
                    id="aiCloseButton"
                    type="button"
                    class="w-9 h-9 rounded-full
                           hover:bg-white/10">

                    <i class="fa-solid fa-xmark"></i>

                </button>

            </div>

        </div>


        <!-- Messages -->
        <div
            id="aiMessages"
            class="h-[455px]
                   overflow-y-auto
                   p-4
                   space-y-3
                   bg-[#FAF8F5]">

            <!-- Welcome Message -->
            <div class="flex justify-start">

                <div
                    class="max-w-[85%]
                           bg-white
                           border border-gray-200
                           rounded-2xl
                           rounded-tl-none
                           px-4 py-3
                           shadow-sm">

                    <p class="text-sm text-gray-700">
                        👋 Assalamualaikum!
                    </p>

                    <p class="text-sm text-gray-600 mt-1">
                        Main MarketLink AI hoon.
                    </p>

                    <div
                        class="mt-3
                               text-xs
                               text-gray-500
                               space-y-1">

                        <p>• "Market page kholo"</p>
                        <p>• "Products kholo"</p>
                        <p>• "Cart kholo"</p>
                        <p>• "Checkout kholo"</p>
                        <p>• "Orders dikhao"</p>

                    </div>

                </div>

            </div>

        </div>


        <!-- Typing Indicator -->
        <div
            id="aiTyping"
            class="hidden px-4 py-2 bg-[#FAF8F5]">

            <div
                class="inline-flex
                       items-center
                       gap-1
                       bg-white
                       border border-gray-200
                       rounded-full
                       px-4 py-2">

                <span
                    class="w-2 h-2
                           bg-gray-400
                           rounded-full
                           animate-bounce">
                </span>

                <span
                    class="w-2 h-2
                           bg-gray-400
                           rounded-full
                           animate-bounce
                           [animation-delay:150ms]">
                </span>

                <span
                    class="w-2 h-2
                           bg-gray-400
                           rounded-full
                           animate-bounce
                           [animation-delay:300ms]">
                </span>

            </div>

        </div>


        <!-- Input -->
        <div class="p-3 border-t bg-white">

            <form
                id="aiChatForm"
                class="flex items-center gap-2">

                @csrf

                <input
                    id="aiMessageInput"
                    type="text"
                    autocomplete="off"
                    placeholder="MarketLink ko command dein..."
                    class="flex-1
                           px-4 py-3
                           rounded-2xl
                           border border-gray-200
                           focus:outline-none
                           focus:ring-2
                           focus:ring-[#005327]/20
                           text-sm">

                <button
                    type="submit"
                    class="w-12 h-12
                           rounded-2xl
                           bg-[#005327]
                           text-white
                           flex items-center
                           justify-center
                           hover:bg-[#003d1c]
                           transition">

                    <i class="fa-solid fa-paper-plane"></i>

                </button>

            </form>

        </div>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const openButton =
        document.getElementById('aiOpenButton');

    const closeButton =
        document.getElementById('aiCloseButton');

    const chatWindow =
        document.getElementById('aiChatWindow');

    const form =
        document.getElementById('aiChatForm');

    const input =
        document.getElementById('aiMessageInput');

    const messages =
        document.getElementById('aiMessages');

    const typing =
        document.getElementById('aiTyping');


    /*
    |--------------------------------------------------------------------------
    | Open Chat
    |--------------------------------------------------------------------------
    */

    openButton.addEventListener('click', function () {

        chatWindow.classList.remove('hidden');

        openButton.classList.add('hidden');

        setTimeout(function () {
            input.focus();
        }, 100);

    });


    /*
    |--------------------------------------------------------------------------
    | Close Chat
    |--------------------------------------------------------------------------
    */

    closeButton.addEventListener('click', function () {

        chatWindow.classList.add('hidden');

        openButton.classList.remove('hidden');

    });


    /*
    |--------------------------------------------------------------------------
    | Escape HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(text) {

        const div =
            document.createElement('div');

        div.textContent = text;

        return div.innerHTML;
    }


    /*
    |--------------------------------------------------------------------------
    | Add Message
    |--------------------------------------------------------------------------
    */

    function addMessage(text, type = 'ai') {

        const wrapper =
            document.createElement('div');


        if (type === 'user') {

            wrapper.className =
                'flex justify-end';

            wrapper.innerHTML = `
                <div
                    class="max-w-[85%]
                           bg-[#005327]
                           text-white
                           rounded-2xl
                           rounded-tr-none
                           px-4 py-3
                           shadow-sm">

                    <p class="text-sm whitespace-pre-wrap">
                        ${escapeHtml(text)}
                    </p>

                </div>
            `;

        } else {

            wrapper.className =
                'flex justify-start';

            wrapper.innerHTML = `
                <div
                    class="max-w-[85%]
                           bg-white
                           border border-gray-200
                           text-gray-700
                           rounded-2xl
                           rounded-tl-none
                           px-4 py-3
                           shadow-sm">

                    <p class="text-sm whitespace-pre-wrap">
                        ${escapeHtml(text)}
                    </p>

                </div>
            `;

        }


        messages.appendChild(wrapper);

        messages.scrollTop =
            messages.scrollHeight;
    }


    /*
    |--------------------------------------------------------------------------
    | Send Message
    |--------------------------------------------------------------------------
    */

    form.addEventListener(
        'submit',
        async function (event) {

            event.preventDefault();


            const message =
                input.value.trim();


            if (!message) {
                return;
            }


            /*
            | User message
            */

            addMessage(
                message,
                'user'
            );


            input.value = '';

            input.disabled = true;

            typing.classList.remove('hidden');


            try {

                const response =
                    await fetch(
                        "{{ route('ai.chat') }}",
                        {
                            method: 'POST',

                            headers: {

                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    document
                                        .querySelector(
                                            'meta[name="csrf-token"]'
                                        )
                                        ?.getAttribute(
                                            'content'
                                        )
                                        ||
                                    "{{ csrf_token() }}"
                            },

                            body: JSON.stringify({
                                message: message
                            })
                        }
                    );


                const data =
                    await response.json();


                /*
                | Error
                */

                if (
                    !response.ok ||
                    !data.success
                ) {

                    addMessage(
                        data.message ||
                        'AI se response nahi mila.'
                    );

                    return;
                }


                /*
                | AI response
                */

                addMessage(
                    data.message ||
                    'Done.'
                );


            } catch (error) {

                console.error(error);

                addMessage(
                    'AI assistant se connection nahi ho saka.'
                );

            } finally {

                typing.classList.add('hidden');

                input.disabled = false;

                input.focus();

            }

        }
    );

});

</script>
    </body>
</html>
