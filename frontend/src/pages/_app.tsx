import { useEffect, useState } from 'react';
import type { AppProps } from 'next/app';
import { ThemeProvider } from '@/context/ThemeContext';
import '@/styles/globals.css';
import Navbar from '@/components/Navbar';
import Footer from '@/components/Footer';
import LoadingScreen from '@/components/LoadingScreen';
import CursorEffect from '@/components/CursorEffect';

export default function App({ Component, pageProps }: AppProps) {
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const timer = setTimeout(() => setLoading(false), 2500);
    return () => clearTimeout(timer);
  }, []);

  return (
    <ThemeProvider>
      <CursorEffect />
      {loading && <LoadingScreen />}
      <div className={`min-h-screen bg-[#0a0a0f] text-white ${loading ? 'opacity-0' : 'opacity-100 transition-opacity duration-500'}`}>
        <Navbar />
        <main>
          <Component {...pageProps} />
        </main>
        <Footer />
      </div>
    </ThemeProvider>
  );
}
