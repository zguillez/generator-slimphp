let isNameValid = false;
let isLastnameValid = false;
let isEmailValid = false;
let isAttachmentValid = false;
let isLegalValid = false;
document.getElementById('form').onsubmit = e => {
  e.preventDefault();
  if (checkInputs()) {
    const data = {
      name: document.getElementById('name').value,
      lastname: document.getElementById('lastname').value,
      email: document.getElementById('email').value,
      attachment: document.getElementById('fileUpload').querySelector('input[name="token"]').value
    };
    axios.post('/users/', data)
      .then(response => {
        console.log(response.data);
        if (response.data.status === 1) {
          document.getElementById('form').style.display = 'none';
          document.getElementById('thanks').style.display = 'block';
        }
      })
      .catch(error => console.log('Error: ', error));
  }
};
document.getElementById('file').onchange = e => {
  e.preventDefault();
  let reader = new FileReader();
  let file = document.getElementById('fileUpload').querySelector('input[name="file"]').files[0];
  let fileName = document.getElementById('fileUpload').querySelector('input[name="file"]').files[0].name;
  if (file) {
    reader.readAsDataURL(file);
    reader.onload = () => {
      axios.post('/upload/', {
        fileName: fileName,
        base64: reader.result,
      })
        .then(response => {
          console.log(response.data);
          document.getElementById('fileUpload').querySelector('input[name="url"]').value = response.data['url'];
          document.getElementById('fileUpload').querySelector('input[name="token"]').value = response.data['token'];
          document.getElementById('fileUpload').querySelector('input[name="file"]').classList.remove('error');
          this["isArchivoValid"] = true;
        })
        .catch(error => {
          console.log('Error: ', error);
          document.getElementById('fileUpload').querySelector('input[name="file"]').classList.add('error');
          this["isArchivoValid"] = false;
        });
    };
    reader.onerror = (error) => {
      console.log('Error: ', error);
    };
  }
};
const checkInputs = () => {
  isLegalValid = document.getElementById('legal').checked;
  console.log(isNameValid, isLastnameValid, isEmailValid, isAttachmentValid, isLegalValid);
  const inputs = document.querySelectorAll('.validate')
  {
    for (let i = 0; i < inputs.length; i++) {
      validaterInput(inputs[i], false);
    }
  }
  if (!isNameValid || !isLastnameValid || !isEmailValid) {
    alert('All fields are required');
    return false;
  }
  if (!isAttachmentValid) {
    alert('You must upload file');
    return false;
  }
  if (!isLegalValid) {
    alert('You must agree');
    return false;
  }
  return true;
}
const validaterInput = (input, showAlert) => {
  this["is" + input.id[0].toUpperCase() + input.id.slice(1) + "Valid"] = false;
  let text;
  let regex;
  if (input.id === "email") {
    regex = /(^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z]{2,4})+$)/;
    text = 'Invalid email';
  } else if (input.id === "telefono") {
    regex = /^(6|7)([0-9]){8}$/;
    text = 'Invalid phone number (9 digits)';
  } else {
    regex = /^[a-zA-ZÀ-ÿ\u00f1\u00d1 ·\-]{2,}$/;
    text = 'Invalid format';
  }
  if (input.value === "") {
    input.classList.add('error');
    if (showAlert) {
      alert("Empty field");
    }
    return false;
  } else if (regex.test(input.value)) {
    input.classList.remove('error');
    this["is" + input.id[0].toUpperCase() + input.id.slice(1) + "Valid"] = true;
    return true;
  } else {
    input.classList.add('error');
    if (showAlert) {
      alert(text);
    }
    return false;
  }
};
