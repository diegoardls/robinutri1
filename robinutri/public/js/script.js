document.addEventListener('DOMContentLoaded', () => {
    // Elementos del DOM
    const chatArea = document.getElementById('chat-area');
    const chatInput = document.getElementById('chat-input');
    const sendButton = document.getElementById('send-button');
    const newChatBtn = document.getElementById('new-chat-btn');
    const chatsList = document.getElementById('chats-list');
    const welcomeMessage = document.getElementById('welcome-message');

    // Cargar chats al iniciar
    cargarChats();

    // Evento para enviar mensaje
    sendButton.addEventListener('click', enviarMensaje);
    chatInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            enviarMensaje();
        }
    });

    // Evento para nuevo chat
    newChatBtn.addEventListener('click', crearNuevoChat);

    // Función para cargar chats del perfil
    function cargarChats() {
        fetch(`/robinutri/index.php/chat/chats?perfil_id=${perfilId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarChats(data.chats);
                }
            })
            .catch(error => {
                console.error('Error cargando chats:', error);
            });
    }

    // Función para mostrar la lista de chats
    function mostrarChats(chats) {
        chatsList.innerHTML = '';

        if (chats.length === 0) {
            chatsList.innerHTML = '<p style="padding: 10px; color: #888;">No hay conversaciones</p>';
            return;
        }

        chats.forEach(chat => {
            const chatElement = document.createElement('div');
            chatElement.className = 'recent-chat-item';
            chatElement.dataset.chatId = chat.id;
            
            const fecha = new Date(chat.fecha_ultimo_mensaje).toLocaleDateString();
            
            chatElement.innerHTML = `
                <div class="chat-info">
                    <span class="chat-name">${chat.nombre_chat}</span>
                    <span class="chat-time">${fecha}</span>
                </div>
            `;

            chatElement.addEventListener('click', () => {
                abrirChat(chat.id);
            });

            chatsList.appendChild(chatElement);
        });
    }

    // Función para crear nuevo chat
    function crearNuevoChat() {
        const formData = new FormData();
        formData.append('perfil_id', perfilId);

        fetch('/robinutri/index.php/chat/create', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                chatActivo = data.chat_id;
                cargarChats();
                limpiarChat();
                welcomeMessage.style.display = 'block';
            } else {
                alert('Error al crear chat: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error creando chat:', error);
            alert('Error de conexión');
        });
    }

    // Función para abrir un chat existente
    function abrirChat(chatId) {
        chatActivo = chatId;
        welcomeMessage.style.display = 'none';
        
        // Cargar mensajes del chat
        fetch(`/robinutri/index.php/chat/messages?chat_id=${chatId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarMensajes(data.mensajes);
                }
            })
            .catch(error => {
                console.error('Error cargando mensajes:', error);
            });
    }

    // Función para enviar mensaje
    function enviarMensaje() {
        const mensaje = chatInput.value.trim();

        if (!mensaje) return;

        // Si no hay chat activo, crear uno nuevo
        if (!chatActivo) {
            crearNuevoChat();
            // Esperar un momento para que se cree el chat
            setTimeout(() => enviarMensajeDespuesDeCrear(mensaje), 500);
            return;
        }

        enviarMensajeAlChat(mensaje);
    }

    function enviarMensajeDespuesDeCrear(mensaje) {
        if (chatActivo) {
            enviarMensajeAlChat(mensaje);
        }
    }

    function enviarMensajeAlChat(mensaje) {
        // Mostrar mensaje del usuario inmediatamente
        mostrarMensajeUsuario(mensaje);
        chatInput.value = '';

        // Enviar al servidor
        const formData = new FormData();
        formData.append('chat_id', chatActivo);
        formData.append('mensaje', mensaje);

        fetch('/robinutri/index.php/chat/send', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar respuesta del bot
                mostrarMensajeBot(data.bot_response);
                cargarChats(); // Actualizar lista de chats
            }
        })
        .catch(error => {
            console.error('Error enviando mensaje:', error);
            mostrarMensajeBot('Lo siento, hubo un error de conexión.');
        });
    }

    // Función para mostrar mensajes del usuario
    function mostrarMensajeUsuario(mensaje) {
        const messageElement = document.createElement('div');
        messageElement.className = 'chat-message user-message';
        messageElement.innerHTML = `<p>${mensaje}</p>`;
        chatArea.appendChild(messageElement);
        scrollToBottom();
    }

    // Función para mostrar mensajes del bot
    function mostrarMensajeBot(mensaje) {
        const messageElement = document.createElement('div');
        messageElement.className = 'chat-message bot-message';
        messageElement.innerHTML = `<p>${mensaje}</p>`;
        chatArea.appendChild(messageElement);
        scrollToBottom();
    }

    // Función para mostrar todos los mensajes de un chat
    function mostrarMensajes(mensajes) {
        chatArea.innerHTML = '';
        welcomeMessage.style.display = 'none';

        mensajes.forEach(mensaje => {
            const messageElement = document.createElement('div');
            messageElement.className = `chat-message ${mensaje.tipo}-message`;
            messageElement.innerHTML = `<p>${mensaje.mensaje}</p>`;
            chatArea.appendChild(messageElement);
        });

        scrollToBottom();
    }

    // Función para limpiar el área de chat
    function limpiarChat() {
        chatArea.innerHTML = '';
        welcomeMessage.style.display = 'block';
    }

    // Función para hacer scroll al final
    function scrollToBottom() {
        chatArea.scrollTop = chatArea.scrollHeight;
    }
});