#include <string>

bool isZero(std::string str, int pos) {
  return(str[pos+1] == 'e' && str[pos+2] == 'r' && str[pos+3] == 'o');
}

bool isOne(std::string str, int pos) {
  return(str[pos+1] == 'n' && str[pos+2] == 'e');
}

bool isTwo(std::string str, int pos) {
  return(str[pos+1] == 'w' && str[pos+2] == 'o');
}

bool isThree(std::string str, int pos) {
  return(str[pos+1] == 'h' && str[pos+2] == 'r' && str[pos+3] == 'e' && str[pos+4] == 'e');
}

bool isFour(std::string str, int pos) {
  return(str[pos+1] == 'o' && str[pos+2] == 'u' && str[pos+3] == 'r');
}

bool isFive(std::string str, int pos) {
  return(str[pos+1] == 'i' && str[pos+2] == 'v' && str[pos+3] == 'e');
}

bool isSix(std::string str, int pos) {
  return(str[pos+1] == 'i' && str[pos+2] == 'x');
}

bool isSeven(std::string str, int pos) {
  return(str[pos+1] == 'e' && str[pos+2] == 'v' && str[pos+3] == 'e' && str[pos+4] == 'n');
}

bool isEight(std::string str, int pos) {
  return(str[pos+1] == 'i' && str[pos+2] == 'g' && str[pos+3] == 'h' && str[pos+4] == 't');
}

bool isNine(std::string str, int pos) {
  return(str[pos+1] == 'i' && str[pos+2] == 'n' && str[pos+3] == 'e');
}

char parseStrNumber(std::string str, int pos) {
  switch(str[pos]) {
    case 'z':
      if(isZero(str, pos)) {
        return '0';
      }
      break;
    case 'o':
      if(isOne(str, pos)) {
        return '1';
      }
      break;
    case 't':
      if(isTwo(str, pos)) {
        return '2';
      }
      else if(isThree(str, pos)) {
        return '3';
      }
      break;
    case 'f':
      if(isFour(str, pos)) {
        return '4';
      }
      else if(isFive(str, pos)) {
        return '5';
      }
      break;
    case 's':
      if(isSix(str, pos)) {
        return '6';
      }
      else if(isSeven(str, pos)) {
        return '7';
      }
      break;
    case 'e':
      if(isEight(str, pos)) {
        return '8';
      }
      break;
    case 'n':
      if(isNine(str, pos)) {
        return '9';
      }
      break;
    default:
      return '-';
  }
  return '-';
}

