import events from './events';

const device = {
  breakpoint: 'desktop',
  init() {
    this.bindEvents();
    this.setBreakpoint();

    return this.breakpoint;
  },

  bindEvents() {
    window.addEventListener('resize', this.setBreakpoint.bind(this));
  },

  setBreakpoint() {
    if (!window.getComputedStyle) return;

    const newBreakpoint = window.getComputedStyle(document.body, ':after')
      .getPropertyValue('content')
      .replace(/['"]+/g, '');

    if (this.breakpoint !== newBreakpoint) {
      this.breakpoint = newBreakpoint;
      events.emit('breakpointChange', this.breakpoint);
    }
  },
};

export default device.init();
