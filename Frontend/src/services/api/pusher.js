import Pusher from "pusher-js";

const config = {
  key: import.meta.env.VITE_REVERB_APP_KEY,
  host: import.meta.env.VITE_REVERB_HOST || "localhost",
  port: import.meta.env.VITE_REVERB_PORT || 8080,
};

const pusher = new Pusher(config.key, {
  wsHost: config.host,
  wsPort: config.port,
  wssPort: config.port,
  forceTLS: false,
  disableStats: true,
  enabledTransports: ["ws", "wss"],
  cluster: "mt1",
  // Configuraciones adicionales para mejorar la estabilidad
  activityTimeout: 120000, // 2 minutos
  pongTimeout: 30000, // 30 segundos
  unavailableTimeout: 10000, // 10 segundos
});

// Solo errores críticos
pusher.connection.bind("error", (err) => {
  console.error("❌ Error de conexión Pusher:", err);
});

export default pusher;
