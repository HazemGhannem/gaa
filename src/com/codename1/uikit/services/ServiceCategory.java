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
import com.codename1.uikit.entities.Category;

import com.codename1.uikit.utils.Statics;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

/**
 *
 * @author hp
 */
public class ServiceCategory {

    public ArrayList<Category> tasks;

    public static ServiceCategory instance = null;
    public boolean resultOK;
    private ConnectionRequest req;

    private ServiceCategory() {
        req = new ConnectionRequest();
    }

    public static ServiceCategory getInstance() {
        if (instance == null) {
            instance = new ServiceCategory();
        }
        return instance;
    }

    public boolean addCategory(Category l) {
        System.out.println(l);
        System.out.println("********");
        String url = Statics.BASE_URL + "gaalouA?name=" + l.getName();
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

    public ArrayList<Category> parseLivraisons(String jsonText) {
        try {
            tasks = new ArrayList<>();
            JSONParser j = new JSONParser();
            Map<String, Object> tasksListJson
                    = j.parseJSON(new CharArrayReader(jsonText.toCharArray()));
            System.out.println(tasksListJson);
            List<Map<String, Object>> list = (List<Map<String, Object>>) tasksListJson.get("root");
            for (Map<String, Object> obj : list) {

                Category t = new Category();
                float id = Float.parseFloat(obj.get("id").toString());
                t.setId((int) id);
                String name = obj.get("name").toString();
                t.setName(name);

                tasks.add(t);

            }

        } catch (IOException ex) {

        }
        return tasks;
    }

    public ArrayList<Category> getAllLivraisons() {
        //String url = Statics.BASE_URL+"/tasks/";
        String url = Statics.BASE_URL + "gaaloulC";
        //String URL ="http://127.0.0.1:8001/json";
        req.setUrl(url);
        req.setPost(false);
        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                tasks = parseLivraisons(new String(req.getResponseData()));
                req.removeResponseListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return tasks;
    }

    public boolean Delete(Category p) {
        String url = Statics.BASE_URL + "supprGaa/" + p.getId();

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

    public boolean modifierProduct(Category l) {
        String url = Statics.BASE_URL + "editAhmed/" + l.getId() + "?name=" + l.getName();
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
