document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        document.querySelectorAll("textarea").forEach((textarea) => {
            if (textarea.id === "as_blockip_db") {
                let cmInstance = textarea.nextElementSibling?.CodeMirror;

                if (cmInstance) {
                    console.log("CodeMirror für 'as_blockip_db' erkannt!");

                    // Prüfen, ob nur Zahlen, Kommas und Zeilenumbrüche eingegeben werden
                    cmInstance.on("change", function () {
                        let value = cmInstance.getValue();
                        if (!/^[0-9.\n]*$/.test(value)) {
                            alert("Nur Zahlen, Komma und neue Zeilen sind erlaubt!");
                            cmInstance.setValue(value.replace(/[^0-9.\n]/g, ""));
                        }
                    });
                } else {
                    console.error("CodeMirror wurde nicht gefunden!");
                }
            }
        });
    }, 2000);
});
