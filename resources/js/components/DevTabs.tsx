import * as Tabs from '@radix-ui/react-tabs';
import DevCode from '../pages/DevCode';
import DevScratch from '../pages/DevScratch';

const DevTabs = () => {
  return (
    <Tabs.Root defaultValue="code" className="flex h-full flex-col">
      <Tabs.List className="flex border-b border-slate-200 bg-slate-50">
        <Tabs.Trigger
          value="code"
          className="px-4 py-2 text-sm font-medium data-[state=active]:border-b-2 data-[state=active]:border-indigo-500 data-[state=active]:text-indigo-600"
        >
          Python / PHP
        </Tabs.Trigger>
        <Tabs.Trigger
          value="scratch"
          className="px-4 py-2 text-sm font-medium data-[state=active]:border-b-2 data-[state=active]:border-indigo-500 data-[state=active]:text-indigo-600"
        >
          Scratch
        </Tabs.Trigger>
      </Tabs.List>
      <Tabs.Content value="code" className="flex-1 overflow-y-auto">
        <DevCode />
      </Tabs.Content>
      <Tabs.Content value="scratch" className="flex-1 overflow-y-auto">
        <DevScratch />
      </Tabs.Content>
    </Tabs.Root>
  );
};

export default DevTabs;
