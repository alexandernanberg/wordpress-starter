const cookie = {
  set(name, value, time) {
    let expires = '';
    if (time) {
      const date = new Date();
      date.setTime(date.getTime() + (time * 24 * 60 * 60 * 1000));
      expires = `; expires=${date.toGMTString()}`;
    }

    document.cookie = `${name}=${value + expires}; path=/`;
  },

  get(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);

    if (parts.length === 2) {
      return parts.pop().split(';').shift();
    }

    return undefined;
  },

  delete(name) {
    this.set(name, '', -1);
  },
};

export default cookie;
