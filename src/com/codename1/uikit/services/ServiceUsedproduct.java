/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.codename1.uikit.services;

import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.ui.events.ActionListener;
import com.codename1.uikit.entities.Usedproduct;
import com.codename1.uikit.utils.Statics;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

/**
 *
 * @author bhk
 */
public class ServiceUsedproduct {

    public ArrayList<Usedproduct> tasks;

    public static ServiceUsedproduct instance = null;
    public boolean resultOK;
    private ConnectionRequest req;

    private ServiceUsedproduct() {
        req = new ConnectionRequest();
    }

    public static ServiceUsedproduct getInstance() {
        if (instance == null) {
            instance = new ServiceUsedproduct();
        }
        return instance;
    }

    public boolean addLivreur(Usedproduct l) {
        System.out.println(l);
        System.out.println("********");
        String url = Statics.BASE_URL + "newProd?name=" + l.getName() + "&description=" + l.getDescription() + "&image=" + l.getImage() + "&prix=" + l.getPrix();
        //  String url = Statics.BASE_URL + "create";

        req.setUrl(url);

        req.setPost(false);

        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK = req.getResponseCode() == 200; //Code HTTP 200 OK
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return resultOK;
    }

    public ArrayList<Usedproduct> parseLivreurs(String jsonText) {
        try {
            tasks = new ArrayList<>();
            JSONParser j = new JSONParser();
            Map<String, Object> tasksListJson
                    = j.parseJSON(new CharArrayReader(jsonText.toCharArray()));
            System.out.println(tasksListJson);
            List<Map<String, Object>> list = (List<Map<String, Object>>) tasksListJson.get("root");
            for (Map<String, Object> obj : list) {

                Usedproduct t = new Usedproduct();
                float id = Float.parseFloat(obj.get("id").toString());
                t.setId((int) id);
                String name = obj.get("name").toString();
                t.setName(name);

                t.setDescription(obj.get("description").toString());
                String image = obj.get("image").toString();
                t.setImage(image);
                float prix = Float.parseFloat(obj.get("prix").toString());
                t.setPrix(prix);
                // float idcategory = Float.parseFloat(obj.get("idcategory").toString());
                //t.setIdCategory((int)idcategory);

                tasks.add(t);

            }

        } catch (IOException ex) {

        }
        return tasks;
    }

    public ArrayList<Usedproduct> getAllLivreurs() {
        //String url = Statics.BASE_URL+"/tasks/";
        String url = Statics.BASE_URL + "jsonProd";
        //String URL ="http://127.0.0.1:8001/json";
        req.setUrl(url);
        req.setPost(false);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                tasks = parseLivreurs(new String(req.getResponseData()));
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return tasks;
    }

    public boolean Delete(Usedproduct p) {
        String url = Statics.BASE_URL + "supprimerJP/" + p.getId();

        req.setUrl(url);
        req.setPost(false);
        req.setFailSilently(true);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK = req.getResponseCode() == 200;
                req.removeResponseListener(this);
            }

        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return resultOK;

    }
    //Update

    public boolean modifierProduct(Usedproduct l) {
        String url = Statics.BASE_URL + "editP/" + l.getId() + "?name=" + l.getName() + "&description=" + l.getDescription() + "&image=" + l.getImage() + "&prix=" + l.getPrix();
        req.setUrl(url);

        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK = req.getResponseCode() == 200;  // Code response Http 200 ok
                req.removeResponseListener(this);
            }
        });

        NetworkManager.getInstance().addToQueueAndWait(req);//execution ta3 request sinon yet3ada chy dima nal9awha
        return resultOK;

    }

}
