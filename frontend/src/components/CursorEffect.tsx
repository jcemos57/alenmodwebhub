'use client';
import { useEffect, useRef } from 'react';

export default function CursorEffect() {
  const cursorRef = useRef<HTMLDivElement>(null);
  const cursorDotRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    const cursor = cursorRef.current;
    const dot = cursorDotRef.current;
    if (!cursor || !dot) return;

    const onMouseMove = (e: MouseEvent) => {
      cursor.style.transform = `translate(${e.clientX}px, ${e.clientY}px)`;
      dot.style.transform = `translate(${e.clientX}px, ${e.clientY}px)`;
    };

    const onMouseOver = (e: MouseEvent) => {
      const target = e.target as HTMLElement;
      if (target.matches('a, button, [data-cursor-hover]')) {
        cursor.classList.add('hovering');
      }
    };

    const onMouseOut = () => {
      cursor.classList.remove('hovering');
    };

    document.addEventListener('mousemove', onMouseMove);
    document.addEventListener('mouseover', onMouseOver);
    document.addEventListener('mouseout', onMouseOut);

    return () => {
      document.removeEventListener('mousemove', onMouseMove);
      document.removeEventListener('mouseover', onMouseOver);
      document.removeEventListener('mouseout', onMouseOut);
    };
  }, []);

  return (
    <>
      <div
        ref={cursorRef}
        className="custom-cursor"
        style={{ position: 'fixed', pointerEvents: 'none', zIndex: 99999 }}
      />
      <div
        ref={cursorDotRef}
        className="fixed w-1 h-1 bg-primary-500 rounded-full pointer-events-none z-[99999] transition-all duration-100"
        style={{ transform: 'translate(-50%, -50%)' }}
      />
    </>
  );
}
