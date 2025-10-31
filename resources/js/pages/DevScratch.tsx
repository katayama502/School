import { useMutation } from '@tanstack/react-query';
import { useState } from 'react';
import ScratchCanvas from '../components/ScratchCanvas';
import { apiClient } from '../lib/api';

const DevScratch = () => {
  const [project, setProject] = useState(() => JSON.stringify({ targets: [] }));

  const saveMutation = useMutation({
    mutationFn: async () => {
      const response = await apiClient.post('/scratch/projects', {
        title: 'Scratch Draft',
        json_path: 'scratch/draft.json',
        thumbnail_path: null,
        visibility: 'draft',
        payload: project,
      });
      return response.data;
    },
  });

  return (
    <div className="rounded border border-slate-200 bg-white p-4 shadow">
      <div className="flex items-center justify-between">
        <h2 className="text-lg font-semibold">Scratch プロジェクト</h2>
        <button
          className="rounded bg-indigo-600 px-4 py-2 text-white"
          onClick={() => saveMutation.mutate()}
        >
          保存
        </button>
      </div>
      <div className="mt-4">
        <ScratchCanvas projectJson={project} onExport={setProject} />
      </div>
    </div>
  );
};

export default DevScratch;
