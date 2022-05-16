/*
 * Copyright (c) 2016, Codename One
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated 
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation 
 * the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, 
 * and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions 
 * of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, 
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A 
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT 
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF 
 * CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE 
 * OR THE USE OR OTHER DEALINGS IN THE SOFTWARE. 
 */

package com.codename1.uikit.pheonixui;
import com.codename1.charts.ChartComponent;
import com.codename1.charts.models.CategorySeries;
import com.codename1.charts.renderers.DefaultRenderer;
import com.codename1.charts.renderers.SimpleSeriesRenderer;
import com.codename1.charts.util.ColorUtil;
import com.codename1.charts.views.PieChart;
import com.codename1.components.ImageViewer;
import com.codename1.notifications.LocalNotification;
import com.codename1.ui.Button;
import com.codename1.ui.Container;
import com.codename1.ui.Display;
import com.codename1.ui.EncodedImage;
import com.codename1.ui.FontImage;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.URLImage;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.util.Resources;
import com.codename1.uikit.entities.Task;
import com.codename1.uikit.services.Service;
import java.io.IOException;
import java.util.ArrayList;

/**
 * The newsfeed form
 *
 * @author Shai Almog
 */
public class affichage extends  BaseForm {
EncodedImage enim;
 Image img;
 ImageViewer imv;
private static final String HTML_API_KEY = "AIzaSyC_i6nNp6sOrxr_VmksWPmibQn5aIHMqoo";
 


    public affichage(Resources res,Task evt) throws IOException {
      
      super("Blog", BoxLayout.y());
        Container c1=new Container();
     installSidemenu(res);
        getToolbar().addMaterialCommandToRightBar("", FontImage.MATERIAL_ARROW_LEFT, new ActionListener() {
                   @Override
                   public void actionPerformed(ActionEvent evt) {
                      new NewsfeedForm(res).showBack();
                   }
               });
        
        
         try {
            enim=EncodedImage.create("/giphy.gif");
        } catch (IOException ex) {
            //Logger.getLogger(MyApplication.class.getName()).log(Level.SEVERE, null, ex);
        }
         Label ll=new Label();
        Label firstname=new Label("firstname : "+evt.getFirstname());
        Label lastname=new Label("lastname : "+evt.getLastname());
        Label email=new Label("email : "+evt.getEmail());
        Label age=new Label("age : "+evt.getAge());
        Label sexe=new Label("sexe : "+evt.getSexe());
        Label password=new Label("password : "+evt.getPassword());
        
       
        
        Button update=new Button("Update");
        Button Delete=new Button("Delete");
        Delete.addActionListener(new ActionListener() {
          @Override
          public void actionPerformed(ActionEvent evvt) {
              Service.getInstance().Delete(evt);
              new NewsfeedForm(res).show();
          }
      });
        
        
        
        update.addActionListener(new ActionListener() {
          @Override
          public void actionPerformed(ActionEvent evvt) {
               new updateProd(res,evt).show();
          }
      });
        
        
        
          
              enim=EncodedImage.create("/giphy.gif");
           
                       
//double[] val=new double[]{};
             // System.out.println(evt.getImage());
            
              add( img);
              add(firstname);
              add(lastname);
              add(age);
              add(email);
              add(password);
              add(sexe);
              add(update);
              add(Delete);
              
           
              
            
         
        
        
        
        
        
        
        
      
       
     
    }
    
    
    
}
