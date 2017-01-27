import device from '../utils/device';
import cookie from '../utils/cookie';
import events from '../utils/events';

const example = function example() {
  // Get device example
  console.log(device);

  // Set cookie example
  cookie.set('test', 'value', 1);

  // Events subscription example
  events.on('breakpointChange', (breakpoint) => {
    console.log(breakpoint);
  });
};

export default example();
