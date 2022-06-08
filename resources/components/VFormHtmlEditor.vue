<template>
  <div class="">
    <div class="">
      <div v-if="toolbar && editor" class="flex flex-wrap mb-4 -mx-2">
        <div class="p-2">
          <button
            class="flex items-center justify-center bg-gray-100 rounded dark:bg-gray-700 h-7 w-7"
            @click="editor.chain().focus().insertTable().run()"
            :class="{ 'is-active': editor.isActive('bold') }"
          >
            <VIcon size="sm" name="table" />
          </button>
        </div>
        <div class="p-2">
          <button
            class="flex items-center justify-center bg-gray-100 rounded dark:bg-gray-700 h-7 w-7"
            @click="editor.chain().focus().addColumnAfter().run()"
            :class="{ 'is-active': editor.isActive('bold') }"
          >
            <VIcon size="sm" name="plus" />
          </button>
        </div>
        <div class="p-2">
          <button
            class="flex items-center justify-center bg-gray-100 rounded dark:bg-gray-700 h-7 w-7"
            @click="editor.chain().focus().toggleBold().run()"
            :class="{ 'is-active': editor.isActive('bold') }"
          >
            <VIcon size="sm" name="bold" />
          </button>
        </div>
        <div class="p-2">
          <button
            class="flex items-center justify-center bg-gray-100 rounded dark:bg-gray-700 h-7 w-7"
            @click="editor.chain().focus().toggleItalic().run()"
            :class="{ 'is-active': editor.isActive('italic') }"
          >
            <VIcon size="sm" name="italic" />
          </button>
        </div>
        <div class="p-2">
          <button
            class="flex items-center justify-center bg-gray-100 rounded dark:bg-gray-700 h-7 w-7"
            @click="editor.chain().focus().toggleStrike().run()"
            :class="{ 'is-active': editor.isActive('strike') }"
          >
            <VIcon size="sm" name="strikethrough" />
          </button>
        </div>
        <div class="p-2">
          <button
            class="flex items-center justify-center bg-gray-100 rounded dark:bg-gray-700 h-7 w-7"
            @click="editor.chain().focus().setParagraph().run()"
            :class="{ 'is-active': editor.isActive('paragraph') }"
          >
            <VIcon size="sm" name="paragraph" />
          </button>
        </div>
        <div class="p-2">
          <button
            class="flex items-center justify-center bg-gray-100 rounded dark:bg-gray-700 h-7 w-7"
            @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
            :class="{ 'is-active': editor.isActive('heading', { level: 1 }) }"
          >h1</button>
        </div>
        <div class="p-2">
          <button
            class="flex items-center justify-center bg-gray-100 rounded dark:bg-gray-700 h-7 w-7"
            @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
            :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }"
          >h2</button>
        </div>
        <div class="p-2">
          <button
            class="flex items-center justify-center bg-gray-100 rounded dark:bg-gray-700 h-7 w-7"
            @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
            :class="{ 'is-active': editor.isActive('heading', { level: 3 }) }"
          >h3</button>
        </div>
        <div class="p-2">
          <button
            class="flex items-center justify-center bg-gray-100 rounded dark:bg-gray-700 h-7 w-7"
            @click="editor.chain().focus().toggleBulletList().run()"
            :class="{ 'is-active': editor.isActive('bulletList') }"
          >
            <VIcon size="sm" name="list-ul" />
          </button>
        </div>
        <div class="p-2">
          <button
            class="flex items-center justify-center bg-gray-100 rounded dark:bg-gray-700 h-7 w-7"
            @click="editor.chain().focus().toggleOrderedList().run()"
            :class="{ 'is-active': editor.isActive('orderedList') }"
          >
            <VIcon size="sm" name="list-ol" />
          </button>
        </div>
        <div class="p-2">
          <button
            class="flex items-center justify-center bg-gray-100 rounded dark:bg-gray-700 h-7 w-7"
            @click="editor.chain().focus().toggleTaskList().run()"
            :class="{ 'is-active': editor.isActive('taskList') }"
          >
            <VIcon size="sm" name="check" />
          </button>
        </div>
        <div class="p-2">
          <button
            class="flex items-center justify-center bg-gray-100 rounded dark:bg-gray-700 h-7 w-7"
            @click="editor.chain().focus().toggleCodeBlock().run()"
            :class="{ 'is-active': editor.isActive('codeBlock') }"
          >
            <VIcon size="sm" name="code" />
          </button>
        </div>
        <div class="p-2">
          <button
            class="flex items-center justify-center bg-gray-100 rounded dark:bg-gray-700 h-7 w-7"
            @click="editor.chain().focus().undo().run()"
          >
            <VIcon size="sm" name="undo" />
          </button>
        </div>
        <div class="p-2">
          <button
            class="flex items-center justify-center bg-gray-100 rounded dark:bg-gray-700 h-7 w-7"
            @click="editor.chain().focus().redo().run()"
          >
            <VIcon size="sm" name="redo" />
          </button>
        </div>
      </div>
    </div>
    <div class="">
      <EditorContent v-bind="$attrs" :editor="editor" class="prose focus:outline-none max-w-none" />
    </div>
  </div>
</template>

<script lang="ts">
import { onBeforeUnmount, watch, ref } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';
import { useEditor, EditorContent } from "@tiptap/vue-3";

import Document from '@tiptap/extension-document'
import Heading from '@tiptap/extension-heading'
import Paragraph from '@tiptap/extension-paragraph'
import Text from '@tiptap/extension-text'
import Bold from '@tiptap/extension-bold'
import Strike from '@tiptap/extension-strike'
import Italic from '@tiptap/extension-italic'
import TaskList from '@tiptap/extension-task-list'
import TaskItem from '@tiptap/extension-task-item'
import ListItem from '@tiptap/extension-list-item'
import BulletList from '@tiptap/extension-bullet-list'
import OrderedList from '@tiptap/extension-ordered-list'
import CodeBlock from '@tiptap/extension-code-block'
import History from '@tiptap/extension-history'
import Placeholder from '@tiptap/extension-placeholder'
import HardBreak from '@tiptap/extension-hard-break'
import Link from '@tiptap/extension-link'
import Mention from '@tiptap/extension-mention'
import Table from '@tiptap/extension-table'
import TableRow from '@tiptap/extension-table-row'
import TableHeader from '@tiptap/extension-table-header'
import TableCell from '@tiptap/extension-table-cell'
import suggestions from '@/composables/useSuggestions';

export default {
  inheritAttrs: false,

  components: {
    EditorContent
  },

  props: {
    modelValue: {
      type: String,
      default: '',
    },
    content: {
      type: String
    },
    onChange: {
      type: Function,
    },
    toolbar: {
      type: Boolean,
      default: true
    },
    placeholder: {
      type: Boolean,
      default: true
    }
  },

  setup(props, ctx) {
    const page = usePage();

    const editor = ref(useEditor({
      content: props.content ?? props.modelValue,
      extensions: [
        Document,
        Heading,
        Paragraph,
        Text,
        Bold,
        Link,
        Strike,
        Italic,
        TaskList,
        TaskItem.configure({
          nested: true,
        }),
        ListItem,
        BulletList,
        OrderedList,
        CodeBlock,
        Placeholder.configure({
            placeholder: props.placeholder ?? 'Write something...',
        }),
        HardBreak,
        History,
        Table.configure({
          resizable: true
        }),
        TableRow,
        TableHeader,
        TableCell,
        Mention.configure({
          HTMLAttributes: {
            class: 'mention',
          },
          suggestion: suggestions,
        }),
      ],
      onUpdate: ({ editor }) => {
        ctx.emit('update:modelValue', editor.getHTML())
      },
    }));

    watch(() => props.modelValue, (value) => {
      if (editor) {
        //@ts-ignore
        const isSame = editor.value.getHTML() === value
        if (isSame) {
          return
        }
        //@ts-ignore
        editor.value.commands.setContent(props.modelValue, false)
      }
    })

    onBeforeUnmount(() => {
      editor?.value?.destroy()
    })

    return { editor };
  },
};
</script>

<style lang="postcss">
.ProseMirror {
  /* Reset styles */
  outline: none;

  &:focus {
    outline: none;
  }
  /* Placeholder (at the top) */
  p.is-editor-empty:first-child::before {
    content: attr(data-placeholder);
    float: left;
    pointer-events: none;
    height: 0;
    margin: 0 !important;
    opacity: 0.4;
  }

  ul {
    margin-top: -0.50em;
    margin-bottom: 1.50em;
  }
}

/* Task list styles */
ul[data-type="taskList"] li {
  @apply flex items-start;
}
ul[data-type="taskList"] li[data-checked="true"] {
  text-decoration: line-through;
  & input[type="checkbox"] {
    @apply bg-blue-600 dark:bg-gray-600;
  }
}
ul[data-type="taskList"] li > label {
  @apply flex items-center -translate-x-7 mt-1.5;
}
ul[data-type="taskList"] li > div {
  @apply -ml-4;
}
ul[data-type="taskList"] input[type="checkbox"] {
  @apply border-gray-300 bg-gray-100 dark:bg-gray-600 rounded
    focus:outline-none focus:ring-1 focus:ring-offset-1
    focus:ring-gray-800 focus:ring-offset-gray-700
     dark:focus:ring-gray-500 dark:focus:ring-offset-gray-400 ;
}

/* Mentions */
.mention {
  @apply rounded bg-blue-100 text-blue-900 px-1 py-px font-medium;
}
</style>
