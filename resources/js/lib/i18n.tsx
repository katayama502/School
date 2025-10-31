import i18n from 'i18next';
import { initReactI18next, I18nextProvider } from 'react-i18next';
import { PropsWithChildren } from 'react';

i18n.use(initReactI18next).init({
  lng: 'ja',
  fallbackLng: 'en',
  resources: {
    ja: {
      translation: {
        dashboard: 'ダッシュボード',
        pendingAssignments: '未提出の課題',
        run: '実行',
        submit: '提出',
      },
    },
    en: {
      translation: {
        dashboard: 'Dashboard',
        pendingAssignments: 'Pending Assignments',
        run: 'Run',
        submit: 'Submit',
      },
    },
  },
});

export const I18nProvider = ({ children }: PropsWithChildren) => {
  return <I18nextProvider i18n={i18n}>{children}</I18nextProvider>;
};
