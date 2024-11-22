(function () {
    if (!window.Socket) {
		
        let instance = null;

        const createSocketConnection = (username) => {
            const socket = new WebSocket(`ws://localhost:9000?username=${username}`);

            socket.onopen = () => {
                console.log(`WebSocket connected for ${username}`);
            };

            socket.onmessage = (event) => {
                console.log(`Message received: ${event.data}`);
            };

            socket.onclose = () => {
                console.log(`WebSocket disconnected for ${username}`);
            };

            socket.onerror = (error) => {
                console.error(`WebSocket error:`, error);
            };

            return socket;
        };

        window.Socket = {
            getInstance: function (username) {
                if (!instance || instance.readyState === WebSocket.CLOSED) {
                    instance = createSocketConnection(username);
                }
                return instance;
            }
        };
    }
})();
