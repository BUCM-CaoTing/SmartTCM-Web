#include <SimpleDHT.h>
#include <Wire.h>
#include <MAX44009.h>

int ADDR = 0x02;
char* addr = "2";

int pinDHT11 = 2;
int pinHum = 3;
int pinSetOutput = A0;//功能配置口，输出低电平
int pinSetInputDHT11 = A1;//功能配置口DHT11，低电平工作，高电平不工作
int pinSetInputMAX44009 = 9;//功能配置口MAX44009，低电平工作，高电平不工作
int pinSetInputHum = A3;//功能配置口土壤湿度，低电平工作，高电平不工作
int pinSetInputSW = 7;//功能配置口继电器，低电平工作，高电平不工作
int pinWaterSW = 4;
int pinTempSW = 5;
int pinLedSW = 6;

int statuDHT11 = 1;
int statuMAX44009 = 1;
int statuHum = 1;
int statuSW = 1;

SimpleDHT11 dht11(pinDHT11);
MAX44009 light;

byte temperature = 0;//环境温度
byte humidity = 0;//环境湿度
int hum = 0;//土壤湿度
float gzd = 0;
int waterSW = 0;
int tempSW = 0;
int ledSW = 0;

unsigned char answer[50];

byte variable[80];
byte index = 0;


void setup() {
  // put your setup code here, to run once:
  Serial.begin(115200);
  pinMode(pinSetOutput, OUTPUT);
  digitalWrite(pinSetOutput, LOW);
  delay(500);
//  Serial.print("pinSet: ");
//  Serial.println(digitalRead(pinSetOutput));
  pinMode(pinSetInputDHT11, INPUT_PULLUP);
  pinMode(pinSetInputMAX44009, INPUT_PULLUP);
  pinMode(pinSetInputHum, INPUT_PULLUP);
  pinMode(pinSetInputSW, INPUT_PULLUP);
  delay(500);
  statuDHT11 = digitalRead(pinSetInputDHT11);
  statuMAX44009 = digitalRead(pinSetInputMAX44009);
  statuHum = digitalRead(pinSetInputHum);
  statuSW = digitalRead(pinSetInputSW);
//  Serial.print("statuDHT11: ");
//  Serial.println(digitalRead(pinSetInputDHT11));
//  Serial.print("statuMAX44009: ");
//  Serial.println(digitalRead(pinSetInputMAX44009));
//  Serial.print("statuHum: ");
//  Serial.println(digitalRead(pinSetInputHum));
//  Serial.print("statuSW: ");
//  Serial.println(digitalRead(pinSetInputSW));
  if(statuMAX44009 == 0){
    Wire.begin();
    light.begin();
  }
  if(statuHum == 0){
    pinMode(pinHum, INPUT_PULLUP);
  }
  if(statuSW == 0){
    pinMode(pinWaterSW, OUTPUT);
    pinMode(pinTempSW, OUTPUT);
    pinMode(pinLedSW, OUTPUT);
  }
  
  
  
}

void loop() {
  // put your main code here, to run repeatedly:
  if(statuDHT11 == 0){
    //Serial.println("DHT11");
    getDHT11();
  }
  if(statuMAX44009 == 0){
    //Serial.println("MAX44009");
    getLight();
  }
  if(statuHum == 0){
    //Serial.println("HUM");
    getHum();
  }
  if(statuSW == 0){
    //Serial.println("SW");
    setSW();
    getSW();
  }
  delay(2000);
}

void getDHT11(){
  // start working...
  // read without samples.
  
  int err = SimpleDHTErrSuccess;
  if ((err = dht11.read(&temperature, &humidity, NULL)) != SimpleDHTErrSuccess) {
    //Serial.print("Read DHT11 failed, err="); Serial.println(err);delay(1000);
    return;
  }
//  clearAnswer();
  Serial.print("1,");//环境温度湿度
  Serial.print(addr);
  Serial.print(",");
  Serial.print(temperature);
  Serial.print(",");
  Serial.print(humidity);
  
//  answer[4] = 0x01; //环境温度湿度
//  answer[5] = 2; //数据长度
//  answer[6] = (int)temperature;
//  answer[7] = (int)humidity;
//  answer[8] = 0x0D;
//  answer[9] = 0x0A;
//  sendData(&answer[0]);

  
//  Serial.print("Sample OK: ");
//  Serial.print((int)temperature); Serial.print(" *C, "); 
//  Serial.print((int)humidity); Serial.println(" H");
  
  // DHT11 sampling rate is 1HZ.
  //delay(100);
}

void getHum(){
  hum = digitalRead(pinHum);
//  clearAnswer();
  Serial.print("2,");//土壤湿度
  Serial.print(addr);
  Serial.print(",");
  Serial.print(hum);
//  answer[4] = 0x02; //土壤湿度
//  answer[5] = 1; //数据长度
//  answer[6] = hum;
//  answer[7] = 0x0D;
//  answer[8] = 0x0A;
//  sendData(&answer[0]);
}

void getLight(){
  gzd = light.get_lux();
//  clearAnswer();
  Serial.print("3,");//光照度
  Serial.print(addr);
  Serial.print(",");
  Serial.print(gzd);
//  answer[4] = 0x03; //光照度
//  answer[5] = 3;//数据长度，2字节整数1字节小数
//  int high = (int)gzd;
//  float low = gzd - high;
//  answer[6] = high / 0xFF;
//  answer[7] = high % 0xFF;
//  answer[8] = (int)(low * 100);
//  answer[9] = 0x0D;
//  answer[10] = 0x0A;
//  sendData(&answer[0]);
  
  //delay(100);
//  Serial.print("lux:");
//  Serial.println(gzd);
}

void getSW(){
  waterSW = digitalRead(pinWaterSW);
  tempSW = digitalRead(pinTempSW);
  ledSW = digitalRead(pinLedSW);
//  clearAnswer();
  Serial.print("4,");//开关状态
  Serial.print(addr);
  Serial.print(",");
  Serial.print(waterSW);
  Serial.print(",");
  Serial.print(tempSW);
  Serial.print(",");
  Serial.print(ledSW);
//  answer[4] = 0x04; //开关状态
//  answer[5] = 3;//数据长度
//  answer[6] = waterSW;
//  answer[7] = tempSW;
//  answer[8] = ledSW;
//  answer[9] = 0x0D;
//  answer[10] = 0x0A;
//  sendData(&answer[0]);
}
void setSW(){
  String data = "";
  while (Serial.available() > 0) {
    data += char(Serial.read());
    delay(2);  
  }
  const char* str;
  str = data.c_str();
  char * t;
  int inde = 0;
  boolean is14 = false;
  boolean isaddr = false;
  int swPin = -1;
  while ((t = split(str, ",")) != NULL) {
    if (inde == 0 && strcmp(t, "14") == 0) {
      is14 = true;
    }
    if(inde == 1 && strcmp(t, addr) == 0) {
      isaddr = true;
    }
    if(is14 && isaddr){
      if(inde == 2){
        if(t == 1){
          swPin = pinWaterSW;
        }
        if(t == 2){
          swPin = pinTempSW;
        }
        if(t == 3){
          swPin = pinLedSW;
        }
      }
      if(inde == 3 && swPin != -1){
        sw(swPin, t);
      }
    }
    //printf("'%s'\n", t);
    inde++;
    str = NULL;
    if(inde == 5) break;
  }

  
}

void sw(int pin, char data[]){
  if(strcmp(data, "0") == 0){
    digitalWrite(pin, LOW);
  }else{
    digitalWrite(pin, HIGH);
  }
}

/*
    str 被分割的字符串
    delim 分割符
 */
char * split(char *str, const char * delim)
{
 static char * s;
 char * p, *r;

 if (str != NULL)
  s = str;

 p = strstr(s, delim);

 if (p == NULL) {
  if (*s == 0)
   return NULL;

  r = s;
  s += strlen(s);
  return r;
 }

 r = s;
 *p = 0;
 s = p + strlen(delim);

 return r;
}

void sendData(char* data){
  Serial.print(data);
  //delay(20);
}

void clearAnswer(){
  for(int i=0;i<46;i++){
    answer[i+4] = 0x00;
  }
}
