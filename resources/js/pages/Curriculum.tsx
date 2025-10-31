import { useQuery } from '@tanstack/react-query';
import { apiClient } from '../lib/api';

const Curriculum = () => {
  const { data } = useQuery({
    queryKey: ['courses'],
    queryFn: async () => {
      const response = await apiClient.get('/courses');
      return response.data as Array<any>;
    },
  });

  return (
    <div className="h-full overflow-y-auto p-4">
      <h2 className="text-lg font-semibold">カリキュラム</h2>
      <div className="mt-4 space-y-3">
        {data?.map((course) => (
          <div key={course.id} className="rounded border border-slate-200 p-3">
            <h3 className="text-base font-bold">{course.title}</h3>
            <p className="text-sm text-slate-500">{course.description}</p>
            <ul className="mt-2 space-y-1">
              {course.units?.map((unit: any) => (
                <li key={unit.id} className="rounded bg-slate-50 p-2">
                  <div className="font-medium">{unit.title}</div>
                  <ul className="ml-4 list-disc text-sm text-slate-600">
                    {unit.lessons?.map((lesson: any) => (
                      <li key={lesson.id}>{lesson.title}</li>
                    ))}
                  </ul>
                </li>
              ))}
            </ul>
          </div>
        ))}
      </div>
    </div>
  );
};

export default Curriculum;
