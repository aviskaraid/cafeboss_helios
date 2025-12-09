  function getCookie(naming){
        const nameEQ = naming + "=";
        const ca = document.cookie.split(";");
        for (let i = 0; i < ca.length; i++) {
          let c = ca[i];
          while (c.charAt(0)=== ' ') {
            c = c.substring(1,c.length);
          }
          if (c.indexOf(nameEQ)===0){
            return decodeURIComponent(c.substring(nameEQ.length,c.length));
          }
        }
        return null;
    }
  function setCookie(name, value, days) {
      let expires = "";
      if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); // Calculate future date in milliseconds
        expires = "; expires=" + date.toUTCString(); // Format to UTC string
      }
      document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }