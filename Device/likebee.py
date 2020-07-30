import os
import cv2
import numpy as np
from picamera import PiCamera
import tensorflow as tf
import argparse
import sys

import qrcode
import RPi.GPIO as GPIO

sys.path.append('..')
from utils import label_map_util
from utils import visualization_utils as vis_util

import time

import random, pygame, sys
from pygame.locals import *

FPS = 60
WINDOWWIDTH = 1024
WINDOWHEIGHT = 600

items = 0
points = 0


camera = PiCamera()

MODEL_NAME = 'ssdlite_mobilenet_v2_coco_2018_05_09'

CWD_PATH = os.getcwd()

PATH_TO_CKPT = os.path.join(CWD_PATH,MODEL_NAME,'frozen_inference_graph.pb')

PATH_TO_LABELS = os.path.join(CWD_PATH,'data','mscoco_label_map.pbtxt')

NUM_CLASSES = 90

label_map = label_map_util.load_labelmap(PATH_TO_LABELS)
categories = label_map_util.convert_label_map_to_categories(label_map, max_num_classes=NUM_CLASSES, use_display_name=True)
category_index = label_map_util.create_category_index(categories)

detection_graph = tf.Graph()
with detection_graph.as_default():
    od_graph_def = tf.GraphDef()
    with tf.gfile.GFile(PATH_TO_CKPT, 'rb') as fid:
        serialized_graph = fid.read()
        od_graph_def.ParseFromString(serialized_graph)
        tf.import_graph_def(od_graph_def, name='')

    sess = tf.Session(graph=detection_graph)


image_tensor = detection_graph.get_tensor_by_name('image_tensor:0')
detection_boxes = detection_graph.get_tensor_by_name('detection_boxes:0')
detection_scores = detection_graph.get_tensor_by_name('detection_scores:0')
detection_classes = detection_graph.get_tensor_by_name('detection_classes:0')
num_detections = detection_graph.get_tensor_by_name('num_detections:0')



def material_detector(frame1, frame2, frame3):
    global points
    
    pictures = [frame1,frame2,frame3]
    
    i = 0
    
    for frame in pictures:    
     
        
        
        gray=cv2.cvtColor(frame,cv2.COLOR_BGR2GRAY)
        ret,th1 = cv2.threshold(gray,80,255,cv2.THRESH_BINARY)
        contours,hierarchy = cv2.findContours(th1, cv2.RETR_EXTERNAL,cv2.CHAIN_APPROX_SIMPLE)
        
        c = max(contours, key = cv2.contourArea)
        
        x,y,w,h = cv2.boundingRect(c)
        rect = cv2.minAreaRect(c) 
        (x_min, y_min), (w_min, h_min), ang = cv2.minAreaRect(c)  
               
        box = cv2.boxPoints(rect)
        box = np.int0(box)
        if x < (WINDOWWIDTH-WINDOWWIDTH/3):
            cv2.drawContours(frame, [box], 0, (0,255,0), 2)
        
        if ang == 0:
                ang = ang + 90
        
        center, size = rect[0], rect[1]
        center, size = tuple(map(int, center)), tuple(map(int, size))


        M = cv2.getRotationMatrix2D(center, ang, 1)
        
        if w*h > 5000:
            img_rot = cv2.warpAffine(frame, M, (WINDOWWIDTH, WINDOWHEIGHT))

            img_crop = cv2.getRectSubPix(img_rot, (int(w_min+150), int(h_min+150)), center)
            
            height, width = img_crop.shape[0], img_crop.shape[1]
            
            if width > height:
            
                    img_crop=cv2.transpose(img_crop)
                    
                    img_crop=cv2.flip(img_crop,flipCode=0)            
        
            frame_expanded = np.expand_dims(img_crop, axis=0)
        else:
            img_crop = frame
            frame_expanded = np.expand_dims(img_crop, axis=0)
        
        i += 1
        
        
        (boxes, scores, classes, num) = sess.run(
            [detection_boxes, detection_scores, detection_classes, num_detections],
            feed_dict={image_tensor: frame_expanded})
        print(classes[0][0]) 
                
        if classes[0][0] == 44.0:
            
            vis_util.visualize_boxes_and_labels_on_image_array(
                img_crop,
                np.squeeze(boxes),
                np.squeeze(classes).astype(np.int32),
                np.squeeze(scores),
                category_index,
                use_normalized_coordinates=True,
                line_thickness=8,
                min_score_thresh=0.40)   
            
            points = 1
            cv2.imwrite('likebee/images/originaldetections'+str(items)+'.jpg', img_crop)
            break
        
        elif i == 3:
            rodada=cv2.flip(img_crop,flipCode=0)
            frame4 = rodada
            pictures.append(frame4)
            cv2.imwrite('rotated'+str(items)+'.jpg', frame4)
            
            frame_expanded = np.expand_dims(frame4, axis=0)
            (boxes, scores, classes, num) = sess.run(
            [detection_boxes, detection_scores, detection_classes, num_detections],
            feed_dict={image_tensor: frame_expanded})
            
            print(classes[0][0]) 
                
            if classes[0][0] == 44.0:
                
                vis_util.visualize_boxes_and_labels_on_image_array(
                    frame4,
                    np.squeeze(boxes),
                    np.squeeze(classes).astype(np.int32),
                    np.squeeze(scores),
                    category_index,
                    use_normalized_coordinates=True,
                    line_thickness=8,
                    min_score_thresh=0.40)   
                
                points = 1
                cv2.imwrite('likebee/images/rotated'+str(items)+'.jpg', frame4)
                break
                
            else:
                points = 0
                
        elif i == 4:
            if w*h > 5000:
                if x < (WINDOWWIDTH-WINDOWWIDTH/3):
                    points = 1
                    cv2.imwrite('likebee/images/imageprocessing'+str(items)+'.jpg', frame)
                    break
            else:
                points = 0

    
    return  points


def main():
    global FPSCLOCK, DISPLAYSURF, BASICFONT
    
    pygame.init()
    FPSCLOCK = pygame.time.Clock()
    DISPLAYSURF = pygame.display.set_mode((WINDOWWIDTH, WINDOWHEIGHT), pygame.FULLSCREEN)
    BASICFONT = pygame.font.Font('freesansbold.ttf', 18)
    pygame.display.set_caption('Like Bee')
    
    start()


def start():    
    i = 0
    print("start")
    start = pygame.image.load("likebee/start.png") 
    
    DISPLAYSURF.blit(pygame.transform.scale(start, (WINDOWWIDTH,WINDOWHEIGHT)), (0,0))  

    pygame.display.update()

    while True:
        
        for event in pygame.event.get():
            if event.type == QUIT:
                terminate()
            elif event.type == KEYDOWN:
                if event.key == K_ESCAPE:
                    terminate()
        
        mouse = pygame.mouse.get_pos()
        click = pygame.mouse.get_pressed()
        
        size_x = 420
        size_y = 95
        
        
        button1_pos_x = ((WINDOWWIDTH/2)-(size_x/2))
        button1_pos_y = ((WINDOWHEIGHT/2)-(size_y/2))
        
        if button1_pos_x < mouse[0] <  button1_pos_x + size_x and button1_pos_y < mouse[1] < button1_pos_y + size_y:
           
            if click[0] == 1:
                i += 1
                if i > 0:
                    i = 0
                    insert()            
    
        
        
        pygame.mouse.set_cursor((8,8),(0,0),(0,0,0,0,0,0,0,0),(0,0,0,0,0,0,0,0))
        pygame.display.update()
        FPSCLOCK.tick(FPS)
   
def insert():
    global items, points
    print("insert")
    insert = pygame.image.load("likebee/insert.png") 
    
    DISPLAYSURF.blit(pygame.transform.scale(insert, (WINDOWWIDTH,WINDOWHEIGHT)), (0,0))  

    pygame.display.update()

    insert_material_open()
    
    time.sleep(1)
    
    insert_material_close()
    
    while True:
        for event in pygame.event.get():
            if event.type == QUIT:
                terminate()      
            elif event.type == KEYDOWN:
                if event.key == K_ESCAPE:
                    terminate()

        pygame.mouse.set_cursor((8,8),(0,0),(0,0,0,0,0,0,0,0),(0,0,0,0,0,0,0,0))
        pygame.display.update()
        FPSCLOCK.tick(FPS)

        if sensor() == 1:
            items += 1

            time.sleep(2)
            
            camera.capture('likebee/images/img'+str(items)+'.1.jpg')
            camera.capture('likebee/images/img'+str(items)+'.2.jpg')
            camera.capture('likebee/images/img'+str(items)+'.3.jpg')

            frame1 = cv2.imread('likebee/images/img'+str(items)+'.1.jpg')
            frame2 = cv2.imread('likebee/images/img'+str(items)+'.2.jpg')
            frame3 = cv2.imread('likebee/images/img'+str(items)+'.3.jpg')
                
        
            points = points + int(material_detector(frame1, frame2, frame3))
            
            
            run()

    
    
   
def run():
    global items
    print("run")
    i = 0
    
    run = pygame.image.load("likebee/run.png") 
    
    DISPLAYSURF.blit(pygame.transform.scale(run, (WINDOWWIDTH,WINDOWHEIGHT)), (0,0))  

    pygame.display.update()
    
    
    
    while True:
        for event in pygame.event.get():
            if event.type == QUIT:
                terminate()    
            elif event.type == KEYDOWN:
                if event.key == K_ESCAPE:
                    terminate()
        
        mouse = pygame.mouse.get_pos()
        click = pygame.mouse.get_pressed()

        
        
        size_x = 370
        size_y = 80
        
        
        button1_pos_x = ((WINDOWWIDTH/2) - size_x)
        button1_pos_y = ((WINDOWHEIGHT/2) - (size_y/2))
        
        button2_pos_x = WINDOWWIDTH/2
        button2_pos_y = ((WINDOWHEIGHT/2) - (size_y/2))
        
        if button1_pos_x < mouse[0] <  button1_pos_x + size_x and button1_pos_y < mouse[1] < button1_pos_y + size_y:
           
            if click[0] == 1:
                i += 1
                if i > 0:
                    i = 0     
                    discart()
                    insert()          

        elif button2_pos_x < mouse[0] <  button2_pos_x + size_x and button2_pos_y < mouse[1] < button2_pos_y + size_y:
            
            if click[0] == 1:
                i += 1
                if i > 1:
                    i = 0
                    
                    
                    result()
                    
        
        pygame.mouse.set_cursor((8,8),(0,0),(0,0,0,0,0,0,0,0),(0,0,0,0,0,0,0,0))
        pygame.display.update()
        FPSCLOCK.tick(FPS)


def result():
    global points, items

    code = pygame.image.load("likebee/code.png")
    DISPLAYSURF.blit(pygame.transform.scale(code, (WINDOWWIDTH,WINDOWHEIGHT)), (0,0))
    pygame.display.update()

    while True:
        for event in pygame.event.get():
            if event.type == QUIT:
                terminate()  
            elif event.type == KEYDOWN:
                if event.key == K_ESCAPE:
                    terminate()
        
        
        qr = qrcode.make(points*1000)
        qr.save("qrcode.png")
        
        pygame.mouse.set_cursor((8,8),(0,0),(0,0,0,0,0,0,0,0),(0,0,0,0,0,0,0,0))
        DISPLAYSURF.blit(pygame.transform.scale(pygame.image.load("likebee/qrcode.png"), (200,200)), ((WINDOWWIDTH/2)-100,(WINDOWHEIGHT/2)-200))
        pygame.display.update()
        
        print("QR code:"+str(points))
        
        print("points"+str(points))
        
        discart()
        items = 0
        points = 0
        time.sleep(8)

        start()

def insert_material_open():
    porta = 19
    travaP = 15
               
    GPIO.setmode(GPIO.BOARD)
    GPIO.setwarnings(False)  
    
    GPIO.setup(porta,GPIO.OUT)             
    GPIO.setup(travaP,GPIO.OUT)
    
    time.sleep(0.25)

    GPIO.output(travaP, GPIO.HIGH)
    time.sleep(0.5)
    portaa = GPIO.PWM(porta,50)              
    portaa.start(3)

    time.sleep(1)
    GPIO.cleanup()
    print("Insert door open")          

def insert_material_close(): 
    porta = 19
    travaP = 15
 
    GPIO.setmode(GPIO.BOARD)
    GPIO.setwarnings(False)  
    
    GPIO.setup(porta,GPIO.OUT)             
    GPIO.setup(travaP,GPIO.OUT)
    
    time.sleep(0.25)
    portaa = GPIO.PWM(porta,50)              
    portaa.start(12)
    
    time.sleep(1)
    
    GPIO.output(travaP, GPIO.LOW)
    time.sleep(0.5)
    GPIO.cleanup()
    print("Insert door close")   
    
def discart():
    door = 13
    lockR = 11
    
    GPIO.setmode(GPIO.BOARD)
    GPIO.setwarnings(False)  
    GPIO.setup(door,GPIO.OUT)             
    GPIO.setup(lockR,GPIO.OUT)
    
    time.sleep(0.25)

    GPIO.output(lockR, GPIO.HIGH)

    time.sleep(0.25)

    doora = GPIO.PWM(door,50)              
    doora.start(5)

    time.sleep(1)

    GPIO.output(lockR, GPIO.LOW)

    time.sleep(0.5)

    doora.ChangeDutyCycle(1.8)
    time.sleep(2)
    GPIO.cleanup()
def sensor():
    # sensor = GPIO.input()
    sensor = 1 
    return sensor
    
def terminate():
    pygame.quit()
    sys.exit()


if __name__ == '__main__':
    main()
