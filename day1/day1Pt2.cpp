#include <iostream>
#include <fstream>
#include <string>
#include <vector>
#include "stringParser.h"

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
