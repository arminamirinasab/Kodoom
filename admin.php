<script>
  let submitAgain = true;
  while (submitAgain) {
    let item1 = prompt("گزینه قسمت تیره رنگ را وارد کنید:");
    let item2 = prompt("گزینه قسمت سفید رنگ را وارد کنید:");
    submitAgain = confirm("آیا قصد ثبت یک سوال جدید را دارید؟")
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        alert(this.responseText);
      }
    };
    xhttp.open("POST", "../api/admin.php", true);
    xhttp.setRequestHeader("Content-type", "application/json");
    xhttp.send(JSON.stringify({
      item1: item1,
      item2: item2
    }));
  }
</script>