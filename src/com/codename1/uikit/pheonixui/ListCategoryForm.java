/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.codename1.uikit.pheonixui;

import com.codename1.components.MultiButton;

import com.codename1.ui.Button;

import com.codename1.ui.Container;
import com.codename1.ui.Form;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.uikit.entities.Category;
import com.codename1.uikit.services.ServiceCategory;

import java.util.Iterator;

/**
 *
 * @author hp
 */
public class ListCategoryForm extends Form{

    public ListCategoryForm(Form previous) {
        
         setTitle("List Category");

          
               Container List = new Container (BoxLayout.y());
    
       
        for (Iterator<Category> it = ServiceCategory.getInstance().getAllLivraisons().iterator(); it.hasNext();) {
            Category l = it.next();
            MultiButton mb = new MultiButton(l.toString());
            //System.out.println(user.getId());
            Button update = new Button("update");
            update.setUIID("update");
            update.addActionListener(e -> new UpdateC(l,previous).show());
            Button delete = new Button("delete");
            delete.setUIID("delete");
            delete.addActionListener(e -> new CategoryDelete(l,previous).show());
            //            for(int i = 0; i < user; i++)
//            {
//                System.out.println();
//                }
add(mb);
add(delete);
add(update);
        }
        
    }

   

   

   
}
