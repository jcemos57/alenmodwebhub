import Head from 'next/head';
import Hero from '@/components/Hero';
import TrustSection from '@/components/TrustSection';
import About from '@/components/About';
import Services from '@/components/Services';
import Skills from '@/components/Skills';
import Projects from '@/components/Projects';
import Experience from '@/components/Experience';
import Testimonials from '@/components/Testimonials';
import Process from '@/components/Process';
import Pricing from '@/components/Pricing';
import Blog from '@/components/Blog';
import Contact from '@/components/Contact';
import FloatingElements from '@/components/FloatingElements';

export default function Home() {
  return (
    <>
      <Head>
        <title>Alenmodwebhub | Full Stack Web Developer - Nigeria</title>
        <meta name="description" content="Professional Full Stack Web Developer from Nigeria. Expert in React, Node.js, PHP, Laravel, and building powerful web experiences that grow businesses." />
        <meta name="keywords" content="Full Stack Developer Nigeria, Web Developer, React Developer, PHP Developer, SaaS Developer, E-commerce Developer" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:title" content="Alenmodwebhub | Full Stack Web Developer - Nigeria" />
        <meta property="og:description" content="Building powerful web experiences that grow businesses." />
        <meta property="og:type" content="website" />
        <link rel="canonical" href="https://alenmodwebhub.com" />
      </Head>
      <FloatingElements />
      <Hero />
      <TrustSection />
      <About />
      <Services />
      <Skills />
      <Projects />
      <Experience />
      <Testimonials />
      <Process />
      <Pricing />
      <Blog />
      <Contact />
    </>
  );
}
