var calculator = {
    started: false,
    display: "000",
    lastType: null,
    calculating: false,
    onReset: function() {
      if (calculator.calculating) return false;

      calculator.started = false;
      calculator.display = "000";

      calculator.updateDisplay();
    },
    onResult: function() {
      calculator.toggleDisplay();
      $.ajax({
          url: "api.php",
          type: "POST",
          data: `{"operation": "${calculator.display}"}`,
          contentType: 'application/json',
          success: function(msg) {
            if(msg.bonus)
              alert("WOW! You're really lucky, you got the same number as result as the random generated one!");

            calculator.display = msg.result;
            calculator.lastType = 'number';
            calculator.updateDisplay();
            calculator.toggleDisplay();
           },
           error: function() {
            calculator.display = 'ERROR';
            calculator.started = false;
            calculator.updateDisplay();
            calculator.toggleDisplay();
           }
      });
    },
    onButtonClicked: function(type, value) {
      if (calculator.calculating) return false;

      if (calculator.started) {
        if (calculator.lastType == type) {
          if (type == "number") calculator.display += value;
          else if(type == "op")
            calculator.display =
              calculator.display.substr(0, calculator.display.length - 2) +
              " " +
              value;
        } else if(type == "dot") {
          calculator.display += value;
        } else if(calculator.lastType == "dot" && type == "number") { 
          calculator.display += value;
        } else {
          calculator.display += " " + value;
        }

        calculator.lastType = type;
      } else {
        if (type == "number") {
          calculator.display = value;
          calculator.started = true;
          calculator.lastType = type;
        }
      }

      calculator.updateDisplay();
    },
    toggleDisplay: function() {
      var display = document.querySelector(".calculator-display");
      var loader = document.querySelector(
        ".calculator-display-container i"
      );
      if (display.classList.contains("hidden")) {
        display.classList.remove("hidden");
        loader.classList.add("hidden");
        calculator.calculating = false;
      } else {
        calculator.calculating = true;
        display.classList.add("hidden");
        loader.classList.remove("hidden");
      }
    },
    updateDisplay: function() {
      document.querySelector(".calculator-display").innerHTML =
        calculator.display;
    }
  };