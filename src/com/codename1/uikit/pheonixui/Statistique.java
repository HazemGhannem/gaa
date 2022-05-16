

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.codename1.uikit.pheonixui;

import com.codename1.charts.ChartComponent;
import com.codename1.charts.models.CategorySeries;
import com.codename1.charts.renderers.DefaultRenderer;
import com.codename1.charts.renderers.SimpleSeriesRenderer;
import com.codename1.charts.util.ColorUtil;
import com.codename1.charts.views.PieChart;
import com.codename1.ui.FontImage;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.util.Resources;
import com.codename1.uikit.entities.Task;

import com.codename1.uikit.services.Service;
import java.util.ArrayList;
import java.util.Collection;
import java.util.Collections;

/**
 *
 * @author ASUS
 */
public class Statistique extends BaseForm{
    
    public Statistique(Resources res){
        installSidemenu(res);
        getToolbar().addMaterialCommandToRightBar("", FontImage.MATERIAL_ARROW_LEFT, new ActionListener() {
                   @Override
                   public void actionPerformed(ActionEvent evt) {
                      new NewsfeedForm(res).showBack();
                   }
               });
    int[] colors = new int[]{ColorUtil.BLUE, ColorUtil.GREEN, ColorUtil.MAGENTA, ColorUtil.YELLOW, ColorUtil.CYAN};
    DefaultRenderer renderer = buildCategoryRenderer(colors);
    renderer.setZoomButtonsVisible(true);
    renderer.setZoomEnabled(true);
    renderer.setChartTitleTextSize(20);
    
    renderer.setDisplayValues(true);
    renderer.setShowLabels(true);
    renderer.setShowLegend(false);
           
              ArrayList<Task> tt=Service.getInstance().getAllTasks();
              CategorySeries series = new CategorySeries("places");
              String nom="";
              int k=0;
              int k1=0;
              int k2=0;
              for(int i=0;i<tt.size();i++){
                 if(tt.get(i).getSexe().equals("masculin")){
                     k++;
                 }
                  
                  if(tt.get(i).getSexe().equals("feminin")){
                     k1++;
                 }
                  
                 
                  
              
              }
              series.add("masculin",k);
              series.add("feminin",k1);
             
              PieChart chart = new PieChart(series, renderer);
              
              ChartComponent c = new ChartComponent(chart);
              this.getStyle().setBgColor(0x4E6868);
              this.getStyle().setBgTransparency(255);
              add(c);
}
    
    private DefaultRenderer buildCategoryRenderer(int[] colors) {
    DefaultRenderer renderer = new DefaultRenderer();
    renderer.setLabelsTextSize(15);
    renderer.setLegendTextSize(15);
    renderer.setMargins(new int[]{20, 30, 15, 0});
    for (int color : colors) {
        SimpleSeriesRenderer r = new SimpleSeriesRenderer();
        r.setColor(color);
        renderer.addSeriesRenderer(r);
    }
    return renderer;
}
}
