import { useMutation } from '@tanstack/react-query';
import { useState } from 'react';
import MonacoEditor from '../components/MonacoEditor';
import { apiClient } from '../lib/api';

const DevCode = () => {
  const [language, setLanguage] = useState<'python' | 'php'>('python');
  const [source, setSource] = useState("print('こんにちは Crietto!')");
  const [result, setResult] = useState<any>(null);

  const runMutation = useMutation({
    mutationFn: async () => {
      const response = await apiClient.post('/runner/execute', {
        language,
        source,
      });
      return response.data;
    },
    onSuccess: (data) => setResult(data),
  });

  return (
    <div className="rounded border border-slate-200 bg-white p-4 shadow">
      <div className="flex items-center justify-between">
        <h2 className="text-lg font-semibold">コード開発</h2>
        <select
          className="rounded border border-slate-200 px-2 py-1"
          value={language}
          onChange={(event) => setLanguage(event.target.value as 'python' | 'php')}
        >
          <option value="python">Python</option>
          <option value="php">PHP</option>
        </select>
      </div>
      <div className="mt-4">
        <MonacoEditor language={language} value={source} onChange={setSource} />
      </div>
      <div className="mt-4 flex gap-2">
        <button
          className="rounded bg-emerald-600 px-4 py-2 text-white"
          onClick={() => runMutation.mutate()}
          disabled={runMutation.isLoading}
        >
          実行
        </button>
      </div>
      {result && (
        <div className="mt-4 grid gap-2 rounded bg-slate-50 p-3 text-sm text-slate-700">
          <div>
            <span className="font-semibold">stdout:</span>
            <pre className="whitespace-pre-wrap text-emerald-700">{result.stdout}</pre>
          </div>
          <div>
            <span className="font-semibold">stderr:</span>
            <pre className="whitespace-pre-wrap text-rose-700">{result.stderr}</pre>
          </div>
          <div className="grid grid-cols-2 gap-2 text-xs text-slate-500">
            <span>exit: {result.exit_code}</span>
            <span>cpu: {result.cpu_ms}ms</span>
            <span>memory: {result.mem_kb}KB</span>
            <span>timeout: {result.timed_out ? 'Yes' : 'No'}</span>
          </div>
        </div>
      )}
    </div>
  );
};

export default DevCode;
