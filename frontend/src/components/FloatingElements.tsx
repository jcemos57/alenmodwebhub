'use client';
import { motion } from 'framer-motion';

export default function FloatingElements() {
  const shapes = [
    { size: 20, color: 'bg-primary-500/20', x: '10%', y: '20%', duration: 6, delay: 0 },
    { size: 15, color: 'bg-accent-500/20', x: '85%', y: '30%', duration: 8, delay: 1 },
    { size: 25, color: 'bg-blue-500/20', x: '70%', y: '70%', duration: 7, delay: 2 },
    { size: 12, color: 'bg-green-500/20', x: '20%', y: '80%', duration: 9, delay: 0.5 },
    { size: 18, color: 'bg-yellow-500/20', x: '50%', y: '15%', duration: 5, delay: 1.5 },
    { size: 10, color: 'bg-purple-500/20', x: '90%', y: '60%', duration: 10, delay: 0.8 },
    { size: 22, color: 'bg-pink-500/20', x: '35%', y: '85%', duration: 6.5, delay: 2.5 },
    { size: 14, color: 'bg-cyan-500/20', x: '60%', y: '40%', duration: 7.5, delay: 1.2 },
  ];

  return (
    <div className="fixed inset-0 pointer-events-none z-0 overflow-hidden">
      {shapes.map((shape, i) => (
        <motion.div
          key={i}
          className={`absolute rounded-full ${shape.color}`}
          style={{
            width: shape.size,
            height: shape.size,
            left: shape.x,
            top: shape.y,
          }}
          animate={{
            y: [0, -30, 0, 20, 0],
            x: [0, 15, -10, 5, 0],
            scale: [1, 1.2, 0.9, 1.1, 1],
            opacity: [0.3, 0.6, 0.2, 0.5, 0.3],
          }}
          transition={{
            duration: shape.duration,
            repeat: Infinity,
            delay: shape.delay,
            ease: 'easeInOut',
          }}
        />
      ))}
    </div>
  );
}
