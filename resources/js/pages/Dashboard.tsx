import { useQuery } from '@tanstack/react-query';
import { useTranslation } from 'react-i18next';
import { apiClient } from '../lib/api';

const Dashboard = () => {
  const { t } = useTranslation();
  const { data } = useQuery({
    queryKey: ['dashboard'],
    queryFn: async () => {
      const response = await apiClient.get('/dashboard');
      return response.data;
    },
  });

  return (
    <div className="rounded border border-slate-200 bg-white p-4 shadow">
      <h2 className="text-lg font-semibold">{t('dashboard')}</h2>
      <div className="mt-3 text-sm text-slate-600">
        <div>到達率: {data?.progress_percent ?? 0}%</div>
        <div className="mt-2">
          <h3 className="font-medium">{t('pendingAssignments')}</h3>
          <ul className="mt-1 list-disc pl-5">
            {data?.pending_assignments?.map((assignment: any) => (
              <li key={assignment.id}>{assignment.title}</li>
            ))}
          </ul>
        </div>
      </div>
    </div>
  );
};

export default Dashboard;
