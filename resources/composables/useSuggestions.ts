import { usePage } from '@inertiajs/inertia-vue3'
import { VueRenderer } from '@tiptap/vue-3'

import VMentionsList from '@/components/VMentionsList.vue';
import tippy from 'tippy.js'

import { SuggestionOptions } from '@tiptap/suggestion';

const options: Omit<SuggestionOptions, 'editor'> = {
  items: ({ query }) => {
    const page = usePage();

    //@ts-ignore
    return page.props.value
        .global
        .users
        .filter(item => item.name.toLowerCase().startsWith(query.toLowerCase())).slice(0, 5)
  },

  render: () => {
    let component
    let popup

    return {
      onStart: props => {
        component = new VueRenderer(VMentionsList, {
          props,
          editor: props.editor,
        })

        popup = tippy('body', {
          getReferenceClientRect: props.clientRect,
          appendTo: () => document.body,
          content: component.element,
          showOnCreate: true,
          interactive: true,
          trigger: 'manual',
          placement: 'bottom-start',
        })
      },

      onUpdate(props) {
        component.updateProps(props)

        popup[0].setProps({
          getReferenceClientRect: props.clientRect,
        })
      },

      onKeyDown(props) {
        if (props.event.key === 'Escape') {
          popup[0].hide()

          return true
        }

        return component.ref?.onKeyDown(props)
      },

      onExit() {
        popup[0].destroy()
        component.destroy()
      },
    }
  },
}

export default options;
