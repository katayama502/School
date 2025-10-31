import '../css/app.css';
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { Suspense } from 'react';
import { createRoot } from 'react-dom/client';
import Dashboard from './pages/Dashboard';
import Curriculum from './pages/Curriculum';
import Growth from './pages/Growth';
import Works from './pages/Works';
import SplitPane from './components/SplitPane';
import DevTabs from './components/DevTabs';
import { useAuth } from './lib/useAuth';
import { I18nProvider } from './lib/i18n';
import { bootstrapAuthToken } from './lib/api';

bootstrapAuthToken();

const queryClient = new QueryClient();

const AppShell = () => {
  const { user, isLoading } = useAuth();

  if (isLoading) {
    return <div className="p-6 text-gray-500">Loading...</div>;
  }

  if (!user) {
    return <div className="p-6 text-gray-700">ログインしてください。</div>;
  }

  return (
    <div className="min-h-screen bg-slate-50 text-slate-900">
      <header className="border-b bg-white p-4 shadow-sm">
        <h1 className="text-lg font-semibold">{user.name} さんの学習ポータル</h1>
      </header>
      <main className="h-[calc(100vh-64px)]">
        <SplitPane left={<Curriculum />} right={<DevTabs />} />
        <section className="grid gap-4 p-4 lg:grid-cols-2">
          <Dashboard />
          <Growth />
          <Works />
        </section>
      </main>
    </div>
  );
};

const container = document.getElementById('app');
if (container) {
  const root = createRoot(container);
  root.render(
    <I18nProvider>
      <QueryClientProvider client={queryClient}>
        <Suspense fallback={<div>Loading...</div>}>
          <AppShell />
        </Suspense>
      </QueryClientProvider>
    </I18nProvider>
  );
}
