#include <iostream>
#include <fstream>
#include <string>
#include <vector>
#include <cctype>

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

    for (char c : myStr) {
      if(isdigit(c)) {
        buildNumber(c, calibration, firstEncounter, tempNumber);
      }
    } calibration += tempNumber;

    calValues.push_back(calibration);
  } 
  myFile.close();
  
  for(std::string calibration : calValues) {
    totalCalibration += std::stoi(calibration);
  }

  std::cout << "Calibration: " << totalCalibration << std::endl;

  return 0;
}
