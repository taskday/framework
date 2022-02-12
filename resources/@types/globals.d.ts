import { defineComponent } from "vue";

declare global {
  interface TaskdayInterface {
    fields: Record<string, ReturnType<typeof defineComponent>>
    filters: Record<string, ReturnType<typeof defineComponent>>
    options: Record<string, ReturnType<typeof defineComponent>>
    views: Record<string, ReturnType<typeof defineComponent>>
    widgets: {[key: string]: ReturnType<typeof defineComponent>}

    registerField(namespace: string, component: ReturnType<typeof defineComponent>): void
    registerFilter(namespace: string, component: ReturnType<typeof defineComponent>): void
    registerOptions(namespace: string, component: ReturnType<typeof defineComponent>): void
    register(namespace: string, component: {
      field: ReturnType<typeof defineComponent>,
      filter?: ReturnType<typeof defineComponent>,
      options?: ReturnType<typeof defineComponent>,
      views?: ReturnType<typeof defineComponent>,
      widgets?: {[key: string]: ReturnType<typeof defineComponent>}
    }): void
  }

  const Taskday: TaskdayInterface;

  function route(route?: string, params?: any): string;
  function taskday(): TaskdayInterface;
  function fieldComponent(type: string): ReturnType<typeof defineComponent>;
  function fieldOptions(type: string): ReturnType<typeof defineComponent>;
  function filterComponent(type: string): ReturnType<typeof defineComponent>;
  function filters(): Record<string, ReturnType<typeof defineComponent>>;

  interface Window {
    Taskday: TaskdayInterface
  }
}

