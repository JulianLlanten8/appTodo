import { useState } from 'react'
import reactLogo from './assets/react.svg'
import viteLogo from '/vite.svg'

function App() {
  const [count, setCount] = useState(0)

  return (
    <div className="h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 flex items-center justify-center p-4">
      <div className="bg-white/10 backdrop-blur-lg rounded-3xl p-8 shadow-2xl border border-white/20 max-w-md w-full text-center">
        {/* Logo Section */}
        <div className="flex justify-center gap-8 mb-8">
          <a href="https://vite.dev" target="_blank" className="group">
            <img 
              src={viteLogo} 
              className="h-16 w-16 transition-transform duration-300 group-hover:scale-110 group-hover:drop-shadow-[0_0_1rem_#646cffaa]" 
              alt="Vite logo" 
            />
          </a>
          <a href="https://react.dev" target="_blank" className="group">
            <img 
              src={reactLogo} 
              className="h-16 w-16 transition-transform duration-300 group-hover:scale-110 group-hover:drop-shadow-[0_0_1rem_#61dafbaa] animate-spin" 
              style={{animationDuration: '20s'}}
              alt="React logo" 
            />
          </a>
        </div>

        {/* Title */}
        <h1 className="text-4xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent mb-8">
          Vite + React
        </h1>

        {/* Counter Card */}
        <div className="bg-white/5 rounded-2xl p-6 mb-6 border border-white/10">
          <button 
            onClick={() => setCount((count) => count + 1)}
            className="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg"
          >
            Contador: {count}
          </button>
          <p className="text-slate-300 text-sm mt-4">
            Edita <code className="bg-slate-800/50 px-2 py-1 rounded text-blue-300">src/App.jsx</code> y guarda para probar HMR
          </p>
        </div>

        {/* Footer */}
        <p className="text-slate-400 text-sm">
          Haz clic en los logos de Vite y React para aprender más
        </p>
      </div>
    </div>
  )
}

export default App
