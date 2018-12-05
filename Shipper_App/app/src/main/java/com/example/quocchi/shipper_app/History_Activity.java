package com.example.quocchi.shipper_app;

import android.content.Context;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.BaseAdapter;
import android.widget.BaseExpandableListAdapter;
import android.widget.Button;
import android.widget.ExpandableListView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class History_Activity extends AppCompatActivity {

//    ListView lvHistory;
    //ArrayList<History> arrayHistory;

    ExpandableListView expandableListView;
    List<String> listdataHeader;
    HashMap<String,ArrayList<History>> listdataChild;

    CustomExpandableListView customExpandableListView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_history);

        expandableListView = (ExpandableListView) findViewById(R.id.expandableListView);
        listdataHeader = new ArrayList<>();
        listdataChild = new HashMap<String,ArrayList<History>>();

        listdataHeader.add("A store");
        listdataHeader.add("B store");
        listdataHeader.add("C store");

        ArrayList<History> store_a = new ArrayList<History>();
        store_a.add(new History("math",1));
        store_a.add(new History("math1",1));
        store_a.add(new History("math2",1));

        ArrayList<History> store_b = new ArrayList<History>();
        store_b.add(new History("english",1));
        store_b.add(new History("english1",1));
        store_b.add(new History("english2",1));

        ArrayList<History> store_c = new ArrayList<History>();
        store_c.add(new History("gaphic",1));
        store_c.add(new History("gaphic1",1));
        store_c.add(new History("gaphic2",1));

        listdataChild.put(listdataHeader.get(0),store_a);
        listdataChild.put(listdataHeader.get(1),store_b);
        listdataChild.put(listdataHeader.get(2),store_c);

        customExpandableListView = new CustomExpandableListView(History_Activity.this,listdataHeader,listdataChild);
        expandableListView.setAdapter(customExpandableListView);
//        lvHistory = (ListView) findViewById(R.id.list_history);
//        arrayHistory = new ArrayList<History>();
//
//
//        arrayHistory.add(new History("math",1));
//        arrayHistory.add(new History("history",1));
//        arrayHistory.add(new History("van hoc",1));
//
//        ArrayAdapter adapter = new ArrayAdapter(History_Activity.this, android.R.layout.simple_list_item_1, arrayHistory);
//
//        lvHistory.setAdapter(adapter);
//
//        lvHistory.setOnItemClickListener(new AdapterView.OnItemClickListener() {
//            @Override
//            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
//                Toast.makeText(History_Activity.this,arrayHistory.get(position).getA(),Toast.LENGTH_SHORT).show();
//
//            }
//        });
    }

    public class CustomExpandableListView extends BaseExpandableListAdapter {

        Context context;
        List<String> listHeader;
        HashMap<String,ArrayList<History>> listChild;

        public CustomExpandableListView(Context context, List<String> listHeader, HashMap<String, ArrayList<History>> listChild) {
            this.context = context;
            this.listHeader = listHeader;
            this.listChild = listChild;
        }

        @Override
        public int getGroupCount() {
            return listHeader.size();
        }

        @Override
        public int getChildrenCount(int groupPosition) {
            return listChild.get(listHeader.get(groupPosition)).size();
        }

        @Override
        public Object getGroup(int groupPosition) {
            return listHeader.get(groupPosition);
        }

        @Override
        public Object getChild(int groupPosition, int childPosition) {
            return listChild.get(listHeader.get(groupPosition)).get(childPosition);
        }

        @Override
        public long getGroupId(int groupPosition) {
            return groupPosition;
        }

        @Override
        public long getChildId(int groupPosition, int childPosition) {
            return childPosition;
        }

        @Override
        public boolean hasStableIds() {
            return false;
        }

        @Override
        public View getGroupView(int groupPosition, boolean isExpanded, View convertView, ViewGroup parent) {
            String headerTitle = (String) getGroup(groupPosition);

            LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

            convertView = inflater.inflate(R.layout.group_history_view,null);
            TextView txtheader = (TextView) convertView.findViewById(R.id.txt_history_header);
            txtheader.setText(headerTitle);

            return convertView;
        }

        @Override
        public View getChildView(int groupPosition, int childPosition, boolean isLastChild, View convertView, ViewGroup parent) {
            History test = (History) getChild(groupPosition,childPosition);

            //History a = listChild.get(listHeader.get(groupPosition));
            LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

            convertView = inflater.inflate(R.layout.group_history_child_view,null);

            TextView txta = (TextView) convertView.findViewById(R.id.txt_a);
            TextView txtb = (TextView) convertView.findViewById(R.id.txt_b);

            txta.setText( test.getA().toString());
            txtb.setText( test.getA().toString());


            return convertView;
        }

        @Override
        public boolean isChildSelectable(int groupPosition, int childPosition) {
            return true;
        }
    }

    private class HistoryAdapter extends BaseAdapter {

        Context myContext;
        int myLayout;
        List<History> arrayOrder;

        public HistoryAdapter(Context context, int layout, List<History> orderList){
            myContext = context;
            myLayout = layout;
            arrayOrder = orderList;
        }

        @Override
        public int getCount() {
            return arrayOrder.size();
        }

        @Override
        public Object getItem(int position) {
            return null;
        }

        @Override
        public long getItemId(int position) {
            return 0;
        }

        @Override
        public View getView(int position, View convertView, ViewGroup parent) {

            LayoutInflater inflater = (LayoutInflater) myContext.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

            convertView = inflater.inflate(myLayout, null);

            //TextView list_item_text = (TextView) convertView.findViewById(R.id.list_item_text);

            final int vitri = position;

//            list_item_text.setText(data.get(position).getA());
//            Button list_item_btn = (Button) convertView.findViewById(R.id.list_item_btn);
//
//            list_item_btn.setOnClickListener(new View.OnClickListener() {
//                @Override
//                public void onClick(View view) {
//                    Toast.makeText(Order_Activity.this,data.get(vitri).getA(),Toast.LENGTH_SHORT).show();
//                }
//            });

            return convertView;
        }
    }


    private class History{
        public String a;
        public int b;

        History(String a, int b){
            this.a = a;
            this.b = b;
        }


        public String getA() {
            return a;
        }

        public void setA(String a) {
            this.a = a;
        }
    }
}
