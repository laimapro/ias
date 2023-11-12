
   
    var temasalvo = localStorage.getItem('selectedTheme');

    if (temasalvo) {
        document.body.className = temasalvo;
    }
