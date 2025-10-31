import { ReactNode } from 'react';
import { useMediaQuery } from '../lib/useMediaQuery';

interface SplitPaneProps {
  left: ReactNode;
  right: ReactNode;
}

const SplitPane = ({ left, right }: SplitPaneProps) => {
  const isDesktop = useMediaQuery('(min-width: 1280px)');

  if (!isDesktop) {
    return (
      <div className="grid grid-cols-1 gap-4 p-4">
        <div className="rounded-lg bg-white p-4 shadow">{left}</div>
        <div className="rounded-lg bg-white p-4 shadow">{right}</div>
      </div>
    );
  }

  return (
    <div className="grid h-full grid-cols-[minmax(300px,1fr)_minmax(400px,2fr)] gap-4 p-4">
      <div className="overflow-hidden rounded-lg bg-white shadow">{left}</div>
      <div className="overflow-hidden rounded-lg bg-white shadow">{right}</div>
    </div>
  );
};

export default SplitPane;
