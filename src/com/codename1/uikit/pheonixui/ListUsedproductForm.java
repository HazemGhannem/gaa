/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.codename1.uikit.pheonixui;

import com.codename1.components.MultiButton;
import com.codename1.components.SpanLabel;
import com.codename1.ui.Button;
import com.codename1.ui.Container;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.uikit.entities.Usedproduct;
import com.codename1.uikit.services.ServiceUsedproduct;
import java.util.Iterator;

/**
 *
 * @author bhk
 */
public class ListUsedproductForm extends Form {

    public ListUsedproductForm(Form previous) {
        setTitle("List Usedproduct");

          
               Container List = new Container (BoxLayout.y());
    
       
        for (Iterator<Usedproduct> it = ServiceUsedproduct.getInstance().getAllLivreurs().iterator(); it.hasNext();) {
            Usedproduct p = it.next();
            MultiButton mb = new MultiButton(p.toString());
            //System.out.println(user.getId());
            Button update = new Button("update");
            update.setUIID("update");
            update.addActionListener(e -> new Update(p,previous).show());
            Button delete = new Button("delete");
            delete.setUIID("delete");
            delete.addActionListener(e -> new LivreurDelete(p,previous).show());
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
