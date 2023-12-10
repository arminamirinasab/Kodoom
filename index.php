<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./assets/css/style.css" />
  <!-- <link rel="preconnect" href="//fdn.fontcdn.ir">
    <link rel="preconnect" href="//v1.fontapi.ir">
    <link href="https://v1.fontapi.ir/css/Estedad" rel="stylesheet"> -->
  <title>کدام؟</title>
</head>

<body>
  <!-- Button White -->
  <button onclick="submitChoice(2)" class="active" id="btnWhite">
    <h2></h2>
    <span></span>
  </button>
  <!-- Button Dark -->
  <button onclick="submitChoice(1)" class="active" id="btnDark">
    <h2></h2>
    <span></span>
  </button>

  <button onclick="newQuestion()" id="btnNext">بعدی</button>
</body>

<script>
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
    xhttp.open("POST", "api/save.php", true);
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
    btnDark.style.width = "50%";
    btnWhite.style.width = "50%";
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
    btnDark.style.width = darkPerc + "%";
    btnWhite.style.width = whitePerc + "%";
    // Enter Percentage In Span
    btnDark.children[1].innerHTML = darkPerc + "%";
    btnWhite.children[1].innerHTML = whitePerc + "%";
  };
</script>

</html>