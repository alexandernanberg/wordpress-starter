const events = {
  events: {},
  on(name, fn) {
    this.events[name] = this.events[name] || [];
    this.events[name].push(fn);
  },

  off(name, fn) {
    if (!this.events[name]) return;

    this.events[name] = this.events[name].filter(item => item !== fn);
  },

  emit(name, data) {
    if (!this.events[name]) return;

    this.events[name].forEach((fn) => {
      fn(data);
    });
  },
};

export default events;
