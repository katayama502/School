import { useQuery } from '@tanstack/react-query';
import { apiClient } from '../lib/api';

const Works = () => {
  const { data } = useQuery({
    queryKey: ['submissions', 'works'],
    queryFn: async () => {
      const response = await apiClient.get('/submissions', { params: { status: 'submitted' } });
      return response.data;
    },
  });

  return (
    <div className="rounded border border-slate-200 bg-white p-4 shadow">
      <h2 className="text-lg font-semibold">作品一覧</h2>
      <div className="mt-2 text-sm text-slate-600">
        {data?.data?.map((submission: any) => (
          <div key={submission.id} className="border-b border-slate-100 py-2">
            <div className="font-medium">{submission.assignment?.title ?? '課題'}</div>
            <div className="text-xs text-slate-500">状態: {submission.status}</div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default Works;
