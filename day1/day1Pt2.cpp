#include <iostream>
#include <fstream>
#include <string>
#include <vector>

bool isNumber(std::string str, int pos, std::string numberStr) {
  for(int i = 0; i < numberStr.size(); i++) {
    if(str[pos + i] != numberStr[i]) {
      return false;
    }
  }
  return true;
}

char parseStrNumber(std::string str, int pos) {
  switch (str[pos]) {
    case 'z': 
      if(isNumber(str, pos, "zero")) return '0';
      break;
    case 'o': 
      if(isNumber(str, pos, "one")) return '1';
      break;
    case 't': 
      if(isNumber(str, pos, "two")) return '2';
      else if (isNumber(str, pos, "three")) return '3';
      break;
    case 'f': 
      if(isNumber(str, pos, "four")) return '4';
      else if (isNumber(str, pos, "five")) return '5';
      break;
    case 's': 
      if(isNumber(str, pos, "six")) return '6';
      else if (isNumber(str, pos, "seven")) return '7';
      break;
    case 'e': 
      if(isNumber(str, pos, "eight")) return '8';
      break;
    case 'n':
      if(isNumber(str, pos, "nine")) return '9';
      break;
    default: return '-';
  }
  return '-';
}

// Function to build the number to be added to the total calibration
void buildNumber(char n, std::string &calibration, bool &firstEncounter, char &tempNumber) {
  if(firstEncounter) {
    firstEncounter = false;
    calibration += n;
  }
  tempNumber = n;
}

int main() {
  std::string myStr;
  std::ifstream myFile("day1.input");  
  std::vector<std::string> calValues;
  int totalCalibration = 0;
  int lines = 0;

  while (getline(myFile, myStr)) {
    bool firstEncounter = true;
    std::string calibration = "";
    char tempNumber;

    for(int i = 0; i < myStr.size(); i++) {
      if(isdigit(myStr[i])) {
        buildNumber(myStr[i], calibration, firstEncounter, tempNumber);
      }
      else { // If the character isn't a digit, then we check if it's a string number
        char parsed = parseStrNumber(myStr, i);
        if(parsed != '-') {
          buildNumber(parsed, calibration, firstEncounter, tempNumber);
        }
      }
    }
    calibration += tempNumber;

    calValues.push_back(calibration);
  } 
  myFile.close();
  
  for(std::string calibration : calValues) {
    totalCalibration += std::stoi(calibration);
  }

  std::cout << "Calibration: " << totalCalibration << std::endl;

  return 0;
}
