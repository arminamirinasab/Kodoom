  // Get Data From The PHP File
  let getRandomQuestion = function(callback) {
    // Send GET Request
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'api/get.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function() {
      if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
        let datas = JSON.parse(this.responseText);
        callback(datas);
      }
    }
    xhr.onerror = function() {
      console.log('یک خطا در ارسال اطلاعات اتفاق افتاد !');
    }
    xhr.send();
  }

  let saveChoiceInDB = function(id, isItem2) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
      }
    };
    xhttp.open("POST", "../../api/save.php", true);
    xhttp.setRequestHeader("Content-type", "application/json");
    xhttp.send(JSON.stringify({
      id: id,
      isItem2: isItem2
    }));

  }

  // Define Global Variables & DOM Elements
  let whiteCount, darkCount, darkPerc, whitePerc, allCount, qid;
  let btnDark = document.querySelector("#btnDark");
  let btnWhite = document.querySelector("#btnWhite");

  // Start New Question
  let newQuestion = function() {
    // Reset Datas
    btnDark.classList.add("active");
    btnWhite.classList.add("active");

    if (window.screen.width > 1320) {
      btnDark.style.width = "50%";
      btnWhite.style.width = "50%";
    } else if (window.screen.width < 1320) {
      btnDark.style.height = "50%";
      btnWhite.style.height = "50%";
      document.querySelector("#btnNext").style.top = "calc(50% - 35px)";
    }

    btnDark.disabled = false;
    btnWhite.disabled = false;
    btnDark.children[1].innerHTML = null;
    btnWhite.children[1].innerHTML = null;
    getRandomQuestion(function(datas) {
      // Get Number Of Counts From DB
      qid = datas.id;
      whiteCount = +datas.votes2;
      darkCount = +datas.votes1;
      // Calculate & All Votes
      allCount = whiteCount + darkCount;
      // Enter Questions In H2
      btnDark.children[0].innerHTML = datas.item1;
      btnWhite.children[0].innerHTML = datas.item2;
    });
  }
  newQuestion();
  // Submit User Select
  let submitChoice = (item) => {
    if (item == 1) {
      saveChoiceInDB(qid, false);
      darkCount++;
    }
    if (item == 2) {
      saveChoiceInDB(qid, true);
      whiteCount++;
    }
    allCount++;

    whitePerc = Math.round(whiteCount / (allCount / 100));
    darkPerc = Math.round(darkCount / (allCount / 100));
    // Change Width & Hover Effect Class
    btnDark.classList.remove("active");
    btnWhite.classList.remove("active");
    btnDark.disabled = true;
    btnWhite.disabled = true;
    if (window.screen.width > 1320) {
      btnDark.style.width = darkPerc + "%";
      btnWhite.style.width = whitePerc + "%";
    } else if (window.screen.width < 1320) {
      btnDark.style.height = darkPerc + "%";
      btnWhite.style.height = whitePerc + "%";
      document.querySelector("#btnNext").style.top = "calc(" + whitePerc + "% - 35px)";
    }

    // Enter Percentage In Span
    btnDark.children[1].innerHTML = darkPerc + "%";
    btnWhite.children[1].innerHTML = whitePerc + "%";
  };