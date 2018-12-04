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
import android.widget.Button;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.List;

public class History_Activity extends AppCompatActivity {

    ListView lvHistory;
    ArrayList<History> arrayHistory;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_history);

        lvHistory = (ListView) findViewById(R.id.list_history);
        arrayHistory = new ArrayList<History>();


        arrayHistory.add(new History("math",1));
        arrayHistory.add(new History("history",1));
        arrayHistory.add(new History("van hoc",1));

        ArrayAdapter adapter = new ArrayAdapter(History_Activity.this, android.R.layout.simple_list_item_1, arrayHistory);

        lvHistory.setAdapter(adapter);

        lvHistory.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Toast.makeText(History_Activity.this,arrayHistory.get(position).getA(),Toast.LENGTH_SHORT).show();

            }
        });
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
