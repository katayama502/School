import { useEffect, useRef } from 'react';
import * as monaco from 'monaco-editor';

type MonacoEditorProps = {
  language: 'python' | 'php';
  value: string;
  onChange(value: string): void;
};

const MonacoEditor = ({ language, value, onChange }: MonacoEditorProps) => {
  const containerRef = useRef<HTMLDivElement | null>(null);
  const editorRef = useRef<monaco.editor.IStandaloneCodeEditor | null>(null);

  useEffect(() => {
    if (!containerRef.current) return;
    editorRef.current = monaco.editor.create(containerRef.current, {
      value,
      language,
      automaticLayout: true,
      theme: 'vs-dark',
      minimap: { enabled: false },
    });

    const subscription = editorRef.current.onDidChangeModelContent(() => {
      onChange(editorRef.current?.getValue() ?? '');
    });

    return () => {
      subscription.dispose();
      editorRef.current?.dispose();
    };
  }, []);

  useEffect(() => {
    if (editorRef.current && value !== editorRef.current.getValue()) {
      editorRef.current.setValue(value);
    }
  }, [value]);

  useEffect(() => {
    if (editorRef.current) {
      const model = editorRef.current.getModel();
      if (model) {
        monaco.editor.setModelLanguage(model, language);
      }
    }
  }, [language]);

  return <div className="h-64 w-full" ref={containerRef} />;
};

export default MonacoEditor;
