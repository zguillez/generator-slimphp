const scripts = require('../inc-all/static/scripts');
test('dummy test', () => {
  expect(scripts.hello).toBe('test ok!');
});
