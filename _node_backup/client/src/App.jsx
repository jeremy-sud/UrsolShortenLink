import React, { useState } from 'react';

function App() {
  const [url, setUrl] = useState('');
  const [shortUrl, setShortUrl] = useState('');
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');
  const [copied, setCopied] = useState(false);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError('');
    setShortUrl('');
    setCopied(false);

    try {
      const response = await fetch('http://localhost:3000/api/shorten', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ originalUrl: url }),
      });

      if (!response.ok) {
        throw new Error('Failed to shorten URL');
      }

      const data = await response.json();
      setShortUrl(data.shortUrl);
    } catch (err) {
      setError('Something went wrong. Please try again.');
    } finally {
      setLoading(false);
    }
  };

  const copyToClipboard = () => {
    navigator.clipboard.writeText(shortUrl);
    setCopied(true);
    setTimeout(() => setCopied(false), 2000);
  };

  return (
    <div className="min-h-screen flex flex-col bg-[#0f172a] text-slate-200 font-sans selection:bg-cyan-500/30 overflow-hidden">
      
      {/* Navbar */}
      <nav className="w-full p-6 flex items-center justify-between max-w-7xl mx-auto z-10">
        <a href="https://ursol.com/" target="_blank" rel="noopener noreferrer" className="flex items-center gap-3 hover:opacity-80 transition-opacity">
          <img src="/iconoUrsol.webp" alt="Sistemas Ursol Logo" className="h-10 w-auto object-contain" />
          <span className="text-xl font-semibold tracking-tight text-white">Sistemas Ursol</span>
        </a>
      </nav>

      {/* Main Content - Panoramic/Horizontal Layout */}
      <main className="flex-1 flex items-center justify-center p-6 w-full max-w-7xl mx-auto">
        <div className="flex flex-col lg:flex-row items-center justify-between w-full gap-12 lg:gap-24">
          
          {/* Left Side: Branding & Text */}
          <div className="flex-1 text-center lg:text-left space-y-6 max-w-2xl">
            <h1 className="text-5xl lg:text-7xl font-bold text-white tracking-tight leading-tight">
              Shorten links, <br />
              <span className="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-600">
                expand reach.
              </span>
            </h1>
            <p className="text-slate-400 text-xl max-w-lg mx-auto lg:mx-0 leading-relaxed">
              The professional URL shortener for modern businesses. Fast, secure, and reliable.
            </p>
            
            {/* Ad Section Placeholder */}
            <div className="mt-8 p-4 border border-slate-700/50 rounded-lg bg-slate-800/30 max-w-md mx-auto lg:mx-0">
              <p className="text-xs text-slate-500 uppercase tracking-widest mb-1">Advertisement</p>
              <p className="text-sm text-slate-400 italic">
                Contactanos para publicitarte en este espacio
              </p>
            </div>
          </div>

          {/* Right Side: Action Card */}
          <div className="flex-1 w-full max-w-xl">
            <div className="glass-panel p-8 lg:p-10 shadow-2xl shadow-cyan-900/20 border border-white/10 bg-white/5 backdrop-blur-xl rounded-3xl">
              <form onSubmit={handleSubmit} className="space-y-4">
                <div>
                  <label htmlFor="url" className="block text-sm font-medium text-slate-300 mb-2 ml-1">
                    Paste your long URL
                  </label>
                  <div className="relative">
                    <input
                      type="url"
                      id="url"
                      required
                      placeholder="https://example.com/very-long-url..."
                      className="w-full px-6 py-4 bg-slate-900/50 border border-slate-700 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent outline-none transition-all text-white placeholder-slate-500 text-lg"
                      value={url}
                      onChange={(e) => setUrl(e.target.value)}
                    />
                  </div>
                </div>

                <button
                  type="submit"
                  disabled={loading}
                  className="w-full py-4 px-6 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white font-bold text-lg rounded-xl transition-all transform hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed shadow-lg shadow-cyan-500/20"
                >
                  {loading ? 'Shortening...' : 'Shorten URL'}
                </button>
              </form>

              {error && (
                <div className="mt-4 p-3 bg-red-500/10 border border-red-500/20 rounded-lg text-red-400 text-sm text-center">
                  {error}
                </div>
              )}

              {shortUrl && (
                <div className="mt-6 p-4 bg-slate-900/50 border border-slate-700 rounded-xl animate-fade-in">
                  <p className="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-2">Your Short Link</p>
                  <div className="flex items-center gap-3">
                    <input
                      type="text"
                      readOnly
                      value={shortUrl}
                      className="flex-1 bg-transparent border-none p-0 text-cyan-400 font-mono text-lg focus:ring-0"
                    />
                    <button
                      onClick={copyToClipboard}
                      className={`px-4 py-2 rounded-lg font-medium text-sm transition-all ${
                        copied
                          ? 'bg-green-500/20 text-green-400'
                          : 'bg-slate-700 hover:bg-slate-600 text-white'
                      }`}
                    >
                      {copied ? 'Copied!' : 'Copy'}
                    </button>
                  </div>
                </div>
              )}
            </div>
          </div>

        </div>
      </main>

      {/* Footer */}
      <footer className="w-full p-6 border-t border-slate-800/50 z-10 bg-[#0f172a]/80 backdrop-blur-sm">
        <div className="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-slate-500">
          <div>
            &copy; {new Date().getFullYear()} <a href="https://ursol.com/" target="_blank" rel="noopener noreferrer" className="hover:text-cyan-400 transition-colors">Sistemas Ursol S.A.</a> All rights reserved.
          </div>
          
          <div className="flex items-center gap-4">
            <span>Developed by</span>
            <a href="https://sites.google.com/view/repdevursol/home" target="_blank" rel="noopener noreferrer" className="group flex items-center gap-2 hover:opacity-100 opacity-70 transition-all">
              <img src="/repdev-logo.png" alt="RepDev Logo" className="h-6 w-auto object-contain grayscale group-hover:grayscale-0 transition-all" />
              <span className="group-hover:text-white transition-colors">RepDev</span>
            </a>
          </div>
        </div>
      </footer>

    </div>
  );
}

export default App;
