export const text_to_speech = (texto) => {
    let speechSynthesis = window.speechSynthesis;
    if(speechSynthesis.speaking) {
        speechSynthesis.cancel();
    } else {
        let text = new SpeechSynthesisUtterance(texto);
        speechSynthesis.speak(text);
    }
    
   
}