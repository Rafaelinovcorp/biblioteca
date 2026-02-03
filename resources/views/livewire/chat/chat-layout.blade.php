<div class="flex h-full">

    {{-- Sidebar --}}
    <livewire:chat.chat-sidebar />

    {{-- Janela de mensagens --}}
    <div class="flex-1">
        @if ($activeConversation)
            <livewire:chat.chat-mensagens
                :conversation-id="$activeConversation->id"
                :key="$activeConversation->id"
            />
        @else
            <div class="h-full flex items-center justify-center text-gray-400">
                Seleciona um utilizador para iniciar uma conversa
            </div>
        @endif
    </div>

</div>
