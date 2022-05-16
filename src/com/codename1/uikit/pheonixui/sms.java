/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.codename1.uikit.pheonixui;

/**
 *
 * @author hp
 */
  import com.twilio.Twilio;
import com.twilio.rest.api.v2010.account.Message;
import com.twilio.type.PhoneNumber;

public class sms {
   
   
    
  // Find your Account Sid and Token at twilio.com/user/account
  public static final String ACCOUNT_SID = "AC549b6e6a32d4a3c028b09d5fe741339b";
  public static final String AUTH_TOKEN = "cd3aa41e7675be2d3af427892953a7fe";

  public static void gaaloul(String text) {
    Twilio.init(ACCOUNT_SID, AUTH_TOKEN);

    Message message = Message.creator(new PhoneNumber("+21625700763"),
        new PhoneNumber("+19803242147"), 
        text).create();

    System.out.println(message.getSid());
  }


 
 }