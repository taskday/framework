import { useModels } from '@/composables/useModels';
import { useChannel } from '@/composables/useChannel';
import { expect, test } from 'vitest'
import useFilter from '@/composables/useFilters2';

test('it can create a filters object', () => {
  const { params } = useFilter();
  expect(params.rules.length).toBe(0);
})

test('it can add one filter', () => {
  const query = useFilter();

  query.add({type: 'status', column: 'feature', operator: '=', value: 'red'});

  expect(query.params.rules.length).toBe(1);
  expect(query.params.rules[0].id).toBeGreaterThan(0);
  expect(query.params.rules[0].type).toBe('status');
  expect(query.params.rules[0].operator).toBe('=');
  expect(query.params.rules[0].value).toBe('red');
})
