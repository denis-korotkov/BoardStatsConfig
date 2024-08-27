function getFields(game) {
    window.location.replace("/game/" + game);
}

function deserializeResults(){
    fetch("http://localhost:8080/admin/deserialize", {
        method: "POST",
        headers: {
            "Content-type": "application/json; charset=UTF-8"
        }
    }).then(r => console.log('deserialized'));
}

function serializeResults(){
    fetch("http://localhost:8080/admin/serialize", {
        method: "POST",
        headers: {
            "Content-type": "application/json; charset=UTF-8"
        }
    }).then(r => console.log('serialized'));
}
