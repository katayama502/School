import { useQuery } from '@tanstack/react-query';
import { apiClient } from '../lib/api';

const Growth = () => {
  const { data } = useQuery({
    queryKey: ['progress'],
    queryFn: async () => {
      const response = await apiClient.get('/progress');
      return response.data as Array<any>;
    },
  });

  const average = data?.reduce((sum, item) => sum + (item.percent ?? 0), 0) ?? 0;
  const percent = data && data.length > 0 ? Math.round(average / data.length) : 0;

  return (
    <div className="rounded border border-slate-200 bg-white p-4 shadow">
      <h2 className="text-lg font-semibold">成長記録</h2>
      <div className="mt-4">
        <div className="text-sm text-slate-600">平均進捗: {percent}%</div>
        <ul className="mt-2 space-y-1 text-sm">
          {data?.map((progress) => (
            <li key={progress.id} className="flex items-center justify-between rounded bg-slate-50 px-2 py-1">
              <span>{progress.lesson?.title ?? 'レッスン'}</span>
              <span className="font-medium">{progress.percent}%</span>
            </li>
          ))}
        </ul>
      </div>
    </div>
  );
};

export default Growth;
