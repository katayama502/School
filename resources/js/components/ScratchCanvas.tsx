import { useEffect, useRef } from 'react';

interface ScratchCanvasProps {
  projectJson: string;
  onExport(data: string): void;
}

const ScratchCanvas = ({ projectJson, onExport }: ScratchCanvasProps) => {
  const canvasRef = useRef<HTMLDivElement | null>(null);

  useEffect(() => {
    if (!canvasRef.current) return;
    canvasRef.current.innerText = 'Scratch VM placeholder';
  }, [projectJson]);

  return (
    <div className="flex flex-col gap-2">
      <div
        ref={canvasRef}
        className="flex h-64 items-center justify-center rounded border border-dashed border-slate-300 p-4 text-center text-sm text-slate-500"
      >
        Scratch VM placeholder
      </div>
      <textarea
        className="h-24 rounded border border-slate-200 p-2 text-xs"
        value={projectJson}
        onChange={(event) => onExport(event.target.value)}
      />
      <button
        type="button"
        className="w-fit rounded bg-indigo-600 px-4 py-2 text-white"
        onClick={() => onExport(projectJson)}
      >
        JSON を更新
      </button>
    </div>
  );
};

export default ScratchCanvas;
