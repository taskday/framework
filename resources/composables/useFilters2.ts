import { reactive, ref } from 'vue';
import _ from 'lodash';

export default function useFilter () {
  const params = reactive<{
    rules: any[]
  }>({
    rules: [],
  });

  function add(filter) {
    filter.id = Math.random();
    filter.column = filter.columns[0] ?? ''
    filter.operator = filter.operators[0] ?? ''
    params.rules.push({...filter});
  }

  function update(value) {
    params.rules.every(element => {
      if (element.id == value.id) {
        element = {...value};
        return false;
      }
      return true;
    });
  }

  function remove(id) {
    params.rules = params.rules.filter(element => {
      return element.id != id
    })
  }

  return { params, add, remove, update };
}
